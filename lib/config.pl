# Utility file included in makenh, addsearch and elsewhere
# Reads archive-specific config information

# We don't do this because other programs use old-style calls
#package config;

# Possible states of a URL
$URL_ERROR=0;
$URL_LOCAL=1;
$URL_REMOTE=2;
$URL_SCRIPT=3;
$URL_TRAVERSE=4;

# name of config file
$CONFIGFILE = "archive.cfg";
$LOCALSERVERSFILE = ".wgservers.cfg";

my($NUM_IP_ADDR_RE) = $siteconf::NUM_IP_ADDR_RE;

# For checking remote urls relative to starting point
%StartingServers=();	# Added 7/14/98 --GB


# Added "vhost" variable to support multiple virtual hosts - GB 7/20/97 
# also added "usemaxmem" to specify -M switch on wgconvert
# valid configuration variables
@ConfigVars = qw(
		 title
		 urlpath
		 traverse_type
		 explicit_only
		 numhops
		 nhhops
		 local_limit
		 remote_limit
		 addboxes
		 vhost
		 usemaxmem
		 urllist
);  # in *that* order


# eg.
#  ($title, $urlpath, $traverse_type, $explicit_only, $numhops,
#   $nhhops, $local_limit, $remote_limit, $addboxes, @urllist) = ReadConfig;
#  SaveConfig ($title, $urlpath, $traverse_type, $explicit_only, $numhops,
#              $nhhops, $local_limit, $remote_limit, $addboxes, @urllist);


########################################################################
# Adapted to read any config file --GB 7/16/98
#
sub RawReadConfig {
   my($indexdir) = shift;
   my($cfgfile) = shift || $CONFIGFILE;
   local(*CFG);
   my(@input);

#   eval {
#	open(CFG, "$indexdir/$cfgfile");
#  };
# Seems to allow read on closed filehandle

#   if($@){
#      return undef;
#   } else {

   if (open(CFG, "$indexdir/$cfgfile")) {
      # read the input
      @input = <CFG>;
      close CFG;
   } else {
#	return undef;
      @input = ();
   }
   return @input;
}

########################################################################
sub ReadConfig {
   my($indexdir) = @_;
   my(@input, @lines, $line);
   my(%Values);

# Added requires for use in new CheckServer & ReadConfig functions --GB 7/14/98
require "URL.pl";
require "siteconf.pl";

   @input = RawReadConfig($indexdir, $CONFIGFILE);
   if(0 == @input) {
      return undef;
   }

   # remove all commented lines
   @lines = grep !/^\s*\#/, @input;

   # remove all blank lines
   @lines = grep !/^\s*$/, @lines;
   
   my($var);

   # fill in the values so there's *something* there...
   foreach $var (@ConfigVars) {
      $Values{$var} = "{}";
   }

   foreach $line (@lines) {
      chomp($line);

      my($okay) = 0;
      foreach $var (@ConfigVars) {
	 if($line =~ /^\s*$var\s*(.*)/i){
	    # if it's not urllist, just assign # Seems to assign urllist too --GB 7/14/98
	    $Values{$var} = $1;
	    $okay = 1;
	    last;
	 }
      }
      if(!$okay){
	 print "Error in configuration file.\n line: $line\n";
      }
   }

   my(@retlist,$svar);
   my($protocol,$host,$port,$path);

   foreach $var (@ConfigVars) {
      if($var ne "urllist"){
	 push(@retlist, $Values{$var});
      }
   }

   # Check for local servers config file
   @input = RawReadConfig($indexdir, $LOCALSERVERSFILE);

   $host = ''; $port = '';

   # If there was no such file
   if(0 == @input) {
	   # Parse urllist to get starting servers. 
	   foreach $svar (split(/\s+/,$Values{"urllist"})) {

		# Get server out of each url. If a directory, use local server.
		if ($svar !~ /^\//) { # Not a directory, assume is a URL
			($protocol,$host,$port,$path) = &url'parse_url($svar);
			if (!defined($port) || $port eq '') { $port = "80"; }
		}
		$host = lc $host;
		$StartingServers{"$host:$port"} = 1;
   	   }
    } else {
	   foreach $svar (@input) {
		($host, $port) = split(/[\s\:]/, "$svar 80", 2);
		if (!defined($port) || $port eq '') { $port = "80"; }		
		$host = lc $host;
		$StartingServers{"$host:$port"} = 1;
	   }
    }

#   # Always add the "real" local server to the StartingServers list (non-remote servers)
#   ($host,$port) = &siteconf'GetServerAddress($Values{$vhost});
#   $host = lc $host;
#   $StartingServers{"$host:$port"} = 1;

   return (@retlist, split(/\s+/, $Values{urllist}));
}


########################################################################
sub SaveConfig {
   my($archivepwd,$toplines,@thearray)=@_;
   local(*CFG);
   my(%Values, @urllist, %ValuesSet);

   my($setstring) = "( ";
   foreach $var (@ConfigVars) {
      if($var ne "urllist"){
	 $setstring .= " \$Values{$var}, ";
      }else {
	 $setstring .= " \@$var ";
      }
   }

   $setstring .= ") = \@thearray;";
   eval $setstring;

   $Values{urllist} = join(" ", @urllist);

   @config = RawReadConfig($archivepwd);

   my($line, $var);
   # substitute the values if they're already there
   foreach $line (@config) {
      foreach $var (@ConfigVars) {
	 if ($line =~ /^\s*$var\s+/) {
	    $line = "$var $Values{$var}\n";
	    $ValuesSet{$var} =1;
	 }
      }
   }

   # now write out the values that aren't there yet
   foreach $var (@ConfigVars) {
      if(!$ValuesSet{$var}){
	 push(@config, "$var $Values{$var}\n"); 
      }
   }

   eval{
      open(CFG, ">$archivepwd/$CONFIGFILE");
   };
   if($@){
      return 0;
   }else{
		print CFG "$toplines\n";
      print CFG @config;
      close CFG;
      return 1;
   }
}

########################################################################
sub TestConfig{
   my($indexdir) = @_;
   
   if(-r "$indexdir/$CONFIGFILE"){
      return 2;
   }
   if(-e "$indexdir/$CONFIGFILE"){
      return 1;
   }
   return 0;
}


########################################################################
sub OldSaveConfig	{
   my($archivepwd,@thearray)=@_;
   my($outstring);
   local(*CFG);
   
   eval{
      open(CFG, ">$archivepwd/$CONFIGFILE");
   };
   if($@){
      return 0;
   }else{
      $outstring = join("\t",@thearray);
      print CFG $outstring;
      close CFG;
      return 1;
   }
}

########################################################################
sub OldReadConfig{
   my($indexdir) = @_;
   my(@input);
   local(*CFG);
   
   eval{
      open(CFG, "$indexdir/$CONFIGFILE");
   };
   if($@){
      return undef;
   } else {
      # read the input
      @input = <CFG>;
      close CFG;

      # remove all commented lines
      
      return split("\t", $input[0]);
   }
}


##########################################################################
# takes 2 params -- file name and assoc array
# uses both BY REFERENCE
#
# Changed to allow explicit pass of IndexPAT & IndexAD hashes
# Moved to config.pl from makenh  --GB  6/30/98
#
sub open_indexallowdeny{
   my($filename) = shift if @_;
   local(*IndexPAT) = shift if @_;
   local(*IndexAD) = shift if @_;

   my($lineno, $AD, $pat, $i);

   $_ = $filename;
   
   # read in the info from file
   open(FILE, "$filename") || (warn "Cannot open file $filename\n" && return);
   
   $lineno=0;
   $i = 0;
   while(<FILE>){
      $lineno++;
      /(\S+)\s*(\S+)/;
      $AD = $1;
      $pat = $2;
      if($AD=~/Allow/i){
	 $IndexPAT[$i] = $pat;
	 $IndexAD[$i] = 1;
      }elsif ($1=~/Deny/i){
	 $IndexPAT[$i] = $pat;
	 $IndexAD[$i] = 0;
      }else{
	 print "Syntax error in $_[0], line $lineno\n";
      }
      $i++;
   }
   close FILE;
}


########################################################################
#  New routine CheckServer replaces old CheckUrl from siteconf.pl
#  Added 7/15/98 --GB
#
#  Accepts URL as input, 
#  Returns URL_LOCAL, URL_REMOTE, URL_SCRIPT, or URL_ERROR
#
sub CheckServer	{
	my($url) = @_;
	my($alias);

	my($protocol,$host,$port,$path) = &url'parse_url($url);

# Added requires for use in new CheckServer function --GB 7/14/98
require "URL.pl";
require "siteconf.pl";
	
	# Now doing error checking -- check for parsing problem --GB 7/16/98
	if (!defined($protocol))	{
		print ERRFILE "Error parsing $url\n";
		print "ERROR\n";
		return $URL_ERROR;
	}

# If this host, port is marked as local, ok
	$host = lc $host;
	if (!defined($port)) {
		$port = "80";
	}

	if (($host eq (lc $siteconf::Server))&&($port eq $siteconf::Port)) {
		foreach $alias (@siteconf::ScriptAliasList){
			if($path =~ /^$alias(.*)/)   {
#				print "SCRIPT.\n";
         			return $URL_SCRIPT;
			}
		}
		return $URL_LOCAL;
	}


	# At this point ReadConfig should already have been called.
	# If not, we don't die but we record an error message & print a warning
	if (! %StartingServers) {
		print ERRFILE "Error: No Starting Servers.  Check that ReadConfig has been run.\n";
		print "WARNING: All URLs considered remote\n";
		return $URL_REMOTE;
	}

# Not that simple now that we potentially check against a whole list of servers
#	if ($port != $Port)	{
#		return $URL_REMOTE;
#	}


	# if the host isn't just numbers and dots... check the names
	my($name,$aliases,$addr,$len,$addrs) = ('','','','','');
	if ($host !~ /^$NUM_IP_ADDR_RE$/o){

		# Check that this is one of our "local" servers
		if (defined($StartingServers{"$host:$port"}) && ($StartingServers{"$host:$port"} == 1)) {
			# print "Same server for url $url...\n";
			return $URL_TRAVERSE;
		}
		if (!defined($siteconf::ServerCache{$host}) || ($siteconf::ServerCache{$host} eq ""))	{
			# print "Looking up host $host...\n";
			($name,$aliases,$addr,$len,$addrs) = gethostbyname($host);
			# print " name: $name, aliases: $aliases\n";
			if (!defined($name) || ($name eq ""))	{
			#	Cannot locate the server!
				print ERRFILE "Cannot find server $host.\n";
				return $URL_ERROR;
			} else	{
				$siteconf::ServerCache{$name} = $addrs;
				$siteconf::ServerCache{$host} = $addrs;

# I think this was an error.  @aliases didn't seem to be definied above. --GB 7/16/98
#				foreach $alias (@aliases)	{

				foreach $alias (split(/\s/,$aliases))	{
					$siteconf::ServerCache{$alias} = $addrs;
				}
			}
		} else	{
			$addrs = $siteconf::ServerCache{$host};
		}
	} else {
		# compute the addr from the name
		# $1, $2, etc. are in the NUM_IP_ADDR_RE
		$addrs = pack('C4', $1, $2, $3, $4);
		# print "Using packed address to determine host ip match...\n";
	}

	# Only allow IP address matching for "real" local server
	# Other servers are identified by name only
	if (($addrs eq $siteconf::ServerAddress) && ($port == $siteconf::Port))	{
		# print "Same address for url $url as local...\n";
		# check to make sure it's not a script
		foreach $alias (@siteconf::ScriptAliasList){
			if($path =~ /^$alias(.*)/)   {
#				print "SCRIPT.\n";
         			return $URL_SCRIPT;
			}
		}
		return $URL_LOCAL;
	}

	return $URL_REMOTE;
}




1;
