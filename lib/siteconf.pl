require "URL.pl";

package siteconf;

# WEBGLIMPSE_HOME will be set automatically by wginstall
$WEBGLIMPSE_HOME = "/home/carole/stonegoddess-www";

$prefix = "^DirectoryIndex|^UserDir|^Alias|^ScriptAlias|^DocumentRoot";

local($DirectoryIndex, $UserDir, $DocumentRoot, $Port, $Server, $ServerAddress);
local(@AliasList,@ScriptAliasList,@ServerCache);

$DirectoryIndex="";
$UserDir="";
$DocumentRoot="";
@AliasList=();
@ScriptAliasList=();
@ServerCache=();
$Port="";
$Server="";
$ServerAddress="";
%HomeDir=();
%Alias=();

$NUM_IP_ADDR_RE = '(\d+)\.(\d+)\.(\d+)\.(\d+)';

$FCacheFile = "$WEBGLIMPSE_HOME/.sitecache";

# If can't write to preferred cache file, use alternate
if (!open(F,">$FCacheFile")) {
	$FCacheFile = "/tmp/.sitecache";
	if (!open(F,">$FCacheFile")) {
		print "Error, cannot find a usable cache file!\n";
		$FCacheFile = '';
	} else {
		close(F);
	}
} else {
	close(F);
}

########################################################################
# Read [vhost].wgsiteconf file settings
sub ReadConf	{
	my($vhost) = @_;
	my(@thearray);
	my(@DirList);
	local(*WMCONF);

	# Have we already read the settings?  Then just return $DocumentRoot --GB 7/15/98
	# This is the only routine where DOCUMENTROOT can be set, so we are safe just checking it
	if (defined($DocumentRoot) && ($DocumentRoot ne '')){
		return $DocumentRoot;
	}

	if (!defined($vhost) || ($vhost eq "default")) {
		$vhost = "";
	}

	$wgConfPath = "$WEBGLIMPSE_HOME/$vhost.wgsiteconf";

	open (WMCONF, "$wgConfPath") || (print "Cannot read $wgConfPath.\n") && return 0;

#	hmm, I am not sure if it's a bug. If you have 2 of
#	DirectoryIndex, UserDir or DocumentRoot, we use the last one.

	# load up the HomeDirArray
	while(@thearray = getpwent()){
		$HomeDir{$thearray[0]} = $thearray[7];
	}


	# Changed 1/18/98 to allow white space at the ends of lines. --GB
	while (<WMCONF>)	{
		if (/^DirectoryIndex[\s]*([\S]*)\s*/i)	{

			$DirectoryIndex = $1;
			
			# Added as per j. holler's suggestion. --GB 10/16/97
			# Get the whole list of possible filenames
			@DirList = split(/\s/);
			$j = 1;
			# Check we got a valid one (could be a .cgi or other non-html)
			while ( ($DirectoryIndex !~ /[hH][tT][mM].*/) && ($j < @DirList)) {
				$DirectoryIndex = $DirList[$j];
				$j++;
			}
			# If we don't think any are valid, go back to the first one
			if ($DirectoryIndex !~ /[hH][tT][mM].*/) {
				$DirectoryIndex = $DirList[1];
			}

		} elsif (/^UserDir[\s]*([\S]*)\s*$/i)	{
			$UserDir = $1;
		} elsif (/^DocumentRoot[\s]*([\S]*)\s*$/i)	{
			$DocumentRoot = $1;
		} elsif (/^Alias[\s]*([\S]*)[\s]*([\S]*)\s*$/i)	{
			push(@AliasList, $2);
			$Alias{$2} = $1;
		} elsif (/^ScriptAlias[\s]*([\S]*)[\s]*([\S]*)\s*$/i)	{
			push(@ScriptAliasList, $2);
		} elsif (/^Port[\s]*([\S]*)\s*$/i)	{
			$Port = $1;
		} elsif (/^Server[\s]*([\S]*)\s*$/i)	{
			$Server = $1;
		}
	}

	close(WMCONF);  # Added 1/18/98 GB. How did we miss this???

	if ($DirectoryIndex eq "")	{
		$DirectoryIndex = "index.html";
	}


	my($name,$aliases,$dm3,$dm4,$addrs) = gethostbyname($Server);
	my($alias);

	my(@aliaslist) = split(/\s+/,$aliases);

	### MDSMITH -- fix for server names
	# add the domain to the name
	my($domain) = $name;
	$domain =~ s/^[^\.]+//;
	### End fix

	$ServerCache{$Server} = $addrs;
	$ServerCache{$name} = $addrs;
	foreach $alias (@aliaslist)	{
		my($wholename) = "${alias}${domain}";

		### MDSMITH -- store both the local name and the whole name
		$ServerCache{$alias} = $addrs;
		$ServerCache{$wholename} = $addrs;
	}
	$ServerAddress = $addrs;

	# Changed to return DocumentRoot setting. --GB 1/18/98.  Previously had no used return value.
	$DocumentRoot;
}

#########################################################################
# Added GetServerAddress routine for use by config.pl	--GB 7/15/98
# Accepts $vhost
# Returns $Server, $Port, calls ReadConf if necessary 
# (often $vhost eq $Server, but not always; $vhost may be "default" or blank)
sub GetServerAddress {
	my $vhost = shift;

	if (!defined($Server) || ($Server eq '')) {
		ReadConf($vhost);
	}
	return($Server, $Port);
}


########################################################################
# Up through version 1.6b4, CheckUrl only checks if the url is local or remote.
# But, when you are traversing links, it may be more important if you 
# have switched from the initial server(s) where the traversal began,
# whether or not the inital point(s) were local.
#
# Tentatively changed in version 1.6b5 to check remote links relative
# to the starting urls. --GB 7/14/98
#
#  The new routine is called CheckServer and is in config.pl (because it depends on archive.cfg, not .wgsiteconf)
#  CheckUrl will no longer be called if this change is made permanent.
#
sub CheckUrl	{
	my($url) = @_;
	my($alias);

	my($protocol,$host,$port,$path) = &url'parse_url($url);
	### TO DO -- error checking -- check for parsing problem
	# if ($protocol==undef)	{
		# print ERRFILE "Error parsing $url\n";
		# print "ERROR\n";
		# return $URL_ERROR;
	# }

	if ($port != $Port)	{
		return $URL_REMOTE;
	}

	# if the host isn't just numbers and dots... check the names
	if ($host !~ /^$NUM_IP_ADDR_RE$/o){
		if ((lc $host) eq (lc $Server))	{
			# print "Same server for url $url...\n";
			# check to make sure it's not a script
			foreach $alias (@ScriptAliasList){
				if($path =~ /^$alias(.*)/)   {
	#				print "SCRIPT.\n";
         				return $URL_SCRIPT;
				}
			}
			return $URL_LOCAL;
		}
	
		if ($ServerCache{$host} eq "")	{
			# print "Looking up host $host...\n";
			my($name,$aliases,$addr,$len,$addrs) = gethostbyname($host);
			# print " name: $name, aliases: $aliases\n";
			if ($name eq "")	{
			#	Cannot locate the server!
				print ERRFILE "Cannot find server $host.\n";
				return $URL_ERROR;
			} else	{
				$ServerCache{$name} = $addrs;
				$ServerCache{$host} = $addrs;
				foreach $alias (@aliases)	{
					$ServerCache{$alias} = $addrs;
				}
			}
		} else	{
			$addrs = $ServerCache{$host};
		}
	} else {
		# compute the addr from the name
		# $1, $2, etc. are in the NUM_IP_ADDR_RE
		$addrs = pack('C4', $1, $2, $3, $4);
		# print "Using packed address to determine host ip match...\n";
	}

	if ($addrs eq $ServerAddress && $port == $Port)	{
		# print "Same address for url $url as local...\n";
		# check to make sure it's not a script
		foreach $alias (@ScriptAliasList){
			if($path =~ /^$alias(.*)/)   {
#				print "SCRIPT.\n";
         			return $URL_SCRIPT;
			}
		}
		return $URL_LOCAL;
	}

	return $URL_REMOTE;
}

########################################################################
#	Assume we have one parameter url, and the argument should be in
#	http:// format, and local.

#  Assume only *local* files will be queried; we already know it's local

# GET RID OF // --GB 1/18/98	The result possibly will have substr like "//"

sub LocalUrl2File	{
	my($url) = @_;
	my($alias, $homedir, $retstring);
	$retstring="";
	my($protocol,$host,$port,$path) = &url'parse_url($url);
	
#	# parse_url only works on fully-qualified URL's.  Otherwise assume it is relative
#	if (! defined($protocol)) {
#		$path = $url;
#	}

#print "Local url $url parses to $protocol, $host, $port, $path\n";

	if ($path =~ /\/$/)	{
		$path .= "$DirectoryIndex";
	}

	# check for home directory
	if($path =~ /^\/~([^\/]+)(.*)/){
		# find the home directory's *real* pwd
		# use getpwent structure, already created
		$homedir = $HomeDir{$1};
		chop ($homedir) if ($homedir=~/\/$/);  # remove any trailing /

		$retstring =  "$homedir/$UserDir$2";
	}else{
		# We want the longest match.
		foreach $alias (@AliasList)	{
			if ($path =~ /^$alias(.*)/)	{
				$path = $Alias{$alias}."/$1";
				$retstring =  $path;
#print "Using alias $alias to make $retstring\n";
			}
		}
	}

	# if no other one works; just return the obvious path
	$retstring =  $DocumentRoot.$path if ($retstring eq "");

	# if it's a directory, add /index.html
	if(-d $retstring){
		# append a / if needed
		$retstring = "$retstring/" if($retstring!~/\/$/);
		$retstring = $retstring.$DirectoryIndex;
	}

# Get rid of // sequences
	$retstring =~ s/\/\//\//g;

	# print "Finally returning $retstring\n";
	return $retstring;
}

sub LocalFile2Url	{
	my($file) = @_;
	my($alias, $homedir, $url, $relpath);

	if ($Port eq "80")	{
		$portPart = "";
	} else	{
		$portPart = ":$Port";
	}

	if ($file =~ /^$DocumentRoot(.*)/)	{
		#$url = "http://$Server$portPart$1"; --> someone suggested this change: should we do it?: bgopal
		$relpath = $1;
		$relpath =~ s/^\///;
		$url = "http://$Server$portPart/$relpath";
		return $url;
	}

	#	We are NOT going for longest match.
	foreach $alias (keys %Alias)	{
		$homedir = $Alias{$alias};
		if ($file =~ /^$homedir(.*)$/)	{
			$url = "http://$Server$portPart$alias/$1";
			return $url;
		}
	}

	return "";
}

# NO GUARANTEE THAT THE USER RUNNING confarc CAN WRITE TO $WEBGLIMPSE_HOME!!!
# Changed fixed filename to $FCacheFile, tested at beginning of package. --GB 7/6/98
sub SaveCache	{
	open (FCACHE, ">$FCacheFile");
	foreach $host (keys %ServerCache)	{
		my($a, $b, $c, $d) = unpack('C4', $ServerCache{$host});
		print FCACHE "$host $a $b $c $d\n";
#		print "$host $a $b $c $d\n";
	}
	close FCACHE;
}

sub LoadCache	{
	open (FCACHE, $FCacheFile);
	while (<FCACHE>)	{
		my($host, $a, $b, $c, $d) = split(' ');
		$ServerCache{$host} = pack('C4', $a, $b, $c, $d);
	}
	close FCACHE;
}

1;
