# Perl routines to configure Webglimpse for a server/domain name


#############################################################
### GLOBALS
###
### Used only within subroutines called by wgSiteConfig
#############################################################

# Values of required fields
$Port = 0;
$ServerName = '';
$DocRoot = '';
$ResourceConfig = '';
$AccessConfig = '';

#############################################################
# wgSiteConfig
#
# Parses web server config file or prompts user to 
# create [vhost].wgsiteconf file with important settings
# Returns DocumentRoot 
#
sub wgSiteConfig {

	my($serverconf,$targetfile,$vhost) = @_;
	my($lines);

	$lines = '';

$Port = 80;
$ServerName = $fulldomain;
$DocRoot = '/home/$username/$domainname-www/';

# Reg exp for parsing out lines to save in .wgsiteconf  
# May get more than one of each of these lines
	$prefix = "^DirectoryIndex|^UserDir|^Alias|^ScriptAlias|^ServerName|^Port|^DocumentRoot|^ResourceConfig|^ServerRoot|^AccessConfig";

# Get Port, ServerName, DocumentRoot, also other settings
	$lines = &SiteConfSetUp($serverconf,$vhost);
	
	if ($ResourceConfig eq '') {
		$ResourceConfig = $serverconf;
		$ResourceConfig =~ s/httpd\.conf$/srm.conf/;
	}

	if ($AccessConfig eq '') {
		$AccessConfig = $serverconf;
		$AccessConfig =~ s/httpd\.conf$/access.conf/;
	}

	if (($ResourceConfig ne '') && ($ResourceConfig ne $serverconf)) {
		$lines .= &SiteConfSetUp($ResourceConfig,$vhost);
	}

	if (($AccessConfig ne '') && ($AccessConfig ne $serverconf)) {
		$lines .= &SiteConfSetUp($AccessConfig,$vhost);
	}

# Ask user if we are missing any settings
	if ($ServerName eq '') {

		$ServerName = `hostname`;
		chomp $ServerName;
		$ServerName = &prompt('Please enter the domain name for this server: ', $ServerName);
	}
	if ($Port == 0) {
		$Port = &prompt('What port is the server running on? ','80');
	}
	if ($DocRoot eq '') {
		$DocRoot = &prompt('Please enter the DocumentRoot for this server: ','');
	}
		

# Write config file
	if ( -e "$targetfile" ) {
		chmod(0644, "$targetfile");
	}
	if (!open (WMCONF, ">$targetfile")) {
		print "\aERROR: Could not find create $targetfile.  Aborting.\n";
		print "If you know your server's configuration information, you may copy the file\n";
		print "example.wgsiteconf from this directory to $targetfile and edit\n";
		print "the contents to match your server's configuration.  If you are installing\n";
		print "webglimpse, you will need to run install.sh again,\n";
		print "and answer Y when prompted to use your existing configuration info.\n\n";
		die;
	}
	print WMCONF "SERVER $ServerName\n";
	print WMCONF "PORT $Port\n";
	print WMCONF "DOCUMENTROOT $DocRoot\n";
	print WMCONF $lines;
	print WMCONF "HTTPDCONF $serverconf\n";
	close WMCONF;

	# make it world-readable
#	chmod(0444, "$targetfile");

	return $DocRoot;
}

#-------------------------------------------------------
# Subroutines
########################################################
#
# SiteConfSetUp parses the server config file for main directives
#     skips any in VirtualHost sections
#     assumes all server directives are on separate lines
#
# Accepts server config file as input
# Outputs string containing all important directive lines
# Sets global variables $DocRoot, $Port, $ServerName, $ResourceConfig, $AccessConfig
#
sub SiteConfSetUp	{
	local($srmConfFile, $vhost) = @_;
	local($key,$override,$val, $ServerRoot);

	open (CONF, $srmConfFile) || return '';

	$override = 0;
	$ServerRoot = '';
	
	while (<CONF>)	{
		# Trim leading white space 
		s/^\s*//g;

		# Skip blank lines and non-applicable VirtualHost directives
		while (/^<VirtualHost\s+([^>]+)/i && ($1 !~ /^($vhost)$/i) && ($_ = <CONF>)) {
			s/^\s*//g;
			while (!/^<\/VirtualHost/i && ($_ = <CONF>)) {
				s/^\s*//g;
			}
		}

		# If we are in an applicable VirtualHost directive, set override on
		/^\<VirtualHost\s+$vhost/i && ($override = 1);

		# If we are leaving a VirtualHost directive, turn override off
		/^\<\/VirtualHost/i && ($override = 0);

		# Get relevant lines
		if (/^($prefix)\s+(.+)$/i)	{
			$key = $1;
			$val = $2;
			$key =~ tr/[a-z]/[A-Z]/;

			# Setting a unique variable; only overwrite existing setting if $override is set
			if (($key eq 'DOCUMENTROOT') && (($DocRoot eq '') || ($override == 1))) {
				$DocRoot = $val;
			} elsif (($key eq 'PORT') && (($Port == 0) || ($override == 1))) {
				$Port = $val;
			} elsif (($key eq 'SERVERNAME') && (($ServerName eq '') || ($override == 1))) {
				$ServerName = $val;
			} elsif (($key eq 'RESOURCECONFIG') && (($ResourceConfig eq '') || ($override == 1))) {
				$ResourceConfig = $val;
			} elsif ($key eq 'SERVERROOT') {
				$ServerRoot = $val;
			} elsif (($key eq 'ACCESSCONFIG') && (($AccessConfig eq '') || ($override == 1))) {
				$AccessConfig = $val;
			} 

			# Or just adding to a list
			else {
				$output .= "$key $val\n";
			}
		}
	}

	close(CONF);

	($ServerRoot ne '') && ($ResourceConfig = $ServerRoot.'/'.$ResourceConfig);	
	($ServerRoot ne '') && ($AccessConfig = $ServerRoot.'/'.$AccessConfig);	

	return $output;
}

1;
