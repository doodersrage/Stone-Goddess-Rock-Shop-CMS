#!/usr/bin/perl -w
use strict;
require "config.cgi";
BEGIN {
        use CGI;
        use DBI;
        use Data::Dumper;
}
use vars qw($DATABASE $HOST $DBUSER $DBPASS $CPUSER $DOMAIN );

my (%tmpElements,%patchElements,$isError);
my $query = new CGI();
my %message;
%message = ( 'MSG1' => 'Please enter email id',                                         
             'MSG2' => 'Please enter mailing list name',                                
             'MSG3' => 'Please enter valid email id',                                   
             'MSG4' => 'No mailing list exists with this name',                         
             'MSG5' => 'No such email id exists in mailing list or already on vacation',
             'MSG6' => 'Failed to open dist file',                                      
             'MSG7' => 'Confirm string value missing in the url',                       
             'MSG8' => 'There was no request for vacation with this email id.',         
             'MSG9' => 'Failed to confirm the on vacation request',
             'MSG10' => 'Your status is changed to "On Vacation".<br> Now all mails from list will be stopped for you untill you change your status as Normal.<br> To Change your status from "On Vacation" to Normal.<br> Visit the following Url.<br><a href="#__NORMAL_URL__#">#__NORMAL_URL__#</a> ',
             'MSG11' => 'Your status is changed to Normal from "On Vacation". So from here on wards all mails from list will be delivered to you.',
	     
	   );
my $emailForm = <<EOF;
	<FORM action="vacation.cgi" method="POST">
	<table width="60%">
	<tr>
	<td colspan=2>
 	<font color="red" size="4">
	#__MESSAGE__#
	</font>
	</td>
	</tr>
	<tr>
	<td colspan=2>
	Please enter your email id and mailling list name.
	After submitting this information,<br> You will recieve a confirmation mail for this vacation request. 
	</td>
	</tr>
	<tr>
	<td>Email Id:</td>
	<td>
	<input type="text" name='email' size="20" value="#__EMAIL__#">
	</td>
	</tr>
  	<tr>
        <td>Mailing List Name:</td>
        <td>
        <input type="text" name='list' size="20" value="#__LIST__#">
        </td>
        </tr>
	<tr>
	<td align="center">
	<input type="submit" value="Submit">&nbsp;
	<input type="reset"  value="Reset">
	</td>
	</tr>
	</table>
	</FORM>
EOF

my $mailContent; 
$mailContent = <<EOF;
It has been requested that the following address:<br><br>

        #__EMAIL__# <br><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; in the #__LIST__# mailing list should be set as on vacation.<br>

 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The address has NOT yet been set as on vacation.<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To set this address on vacation Please visit the following Link.<br><br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#__THIS_CONFIRM_URL__#">#__THIS_CONFIRM_URL__#</a>
EOF
    
    print $query->header();
my $tmplStr;
open TMPL,"tmpl.html" || print "Can not open template file ";
while (<TMPL>){
    $tmplStr .= $_;
}
close TMPL;

#Display the form for submitting emailid.
if ( $ENV{'REQUEST_METHOD'} =~ /GET/i) {
    if ( ! $query->param() ){
	$emailForm = patchString($emailForm,\%tmpElements);
	$tmpElements{MESSAGE} = $emailForm;
	$tmpElements{HEAD}    = "On Vacation Request";
	#print $tmplStr;
	print patchString($tmplStr,\%tmpElements);
	#print $emailForm;
	exit;
    } else {
	my ( $email, $list, $confirm, $backfromvac ) = ( $query->param('email'), $query->param('list'), $query->param('confirm'), $query->param('backfromvac')  );
	my($dom,$dummy)=split(/\./,$DOMAIN);

	my $listDir = '/home/'.$CPUSER.'/'.$dom.'-mail/'.$list;
	my $distFil = $listDir . '/' .'dist';
	if ($email =~ /^\s*$/){
	    $tmpElements{'MESSAGE'} = $message{'MSG1'};
	    $isError = 1;
	} elsif ($list =~ /^\s*$/){
	    $tmpElements{'MESSAGE'} = $message{'MSG2'};
	    $isError = 1;
	} elsif ( $email !~ /(.*?)@(.*?)\.(.*?)/ ){
	    $tmpElements{'MESSAGE'} = $message{'MSG3'};
	    $isError = 1;
	} elsif ($confirm =~ /^\s*$/){
	    $tmpElements{'MESSAGE'} = $message{'MSG7'};
	    $isError = 1;
	} elsif ( ( ! -d $listDir) && ( ! -e $distFil ) ) {
	    $tmpElements{'MESSAGE'} = $message{'MSG4'};
	    $isError = 1;
	} else { #All Values Correct
	    my $sql = qq(SELECT * FROM `smartlist_vacation` WHERE `list` = '$list' AND `email_id` = '$email' AND `confirm_str` = '$confirm' );
	    #AND `is_confirm` = 'N'
	    my $DBH = DBI->connect("dbi:mysql:$DATABASE:$HOST", "$DBUSER", "$DBPASS",
				   {RaiseError => 0, PrintError => 0} )
		or die("Cannot connect to the database");
	    my $confirmStr = generate_random_string(10);
	    my $sth = $DBH->prepare( $sql );
	    if ( $sth->execute() > 0 ) { ## 
		if ( ! $backfromvac ) {
		    my $sqlUpdate = qq(UPDATE `smartlist_vacation` SET `is_confirm` = 'Y' WHERE `list` = '$list' AND `email_id` = '$email' AND `confirm_str` = '$confirm' AND `is_confirm` = 'N' ) ;
		    my $rowsUpdated = $DBH->do( $sqlUpdate );
		    if ( $rowsUpdated > 0 ) {
			$tmpElements{'MESSAGE'} = $message{'MSG10'};
			my $normal_url  = 'http://'.$DOMAIN.'/cgi-bin/smartlist_vacation/vacation.cgi'; 
			$normal_url .= '?email='.$email.'&list='.$list.'&confirm='.$confirm.'&backfromvac=1';
			my %urlElements;
			$urlElements{'NORMAL_URL'} = $normal_url;
			$tmpElements{'MESSAGE'} = patchString($message{'MSG10'},\%urlElements);
			
			# Now remove the email ID from the dist file.
			open(FILE, "+<$distFil");
			$/ = '';
			flock(FILE, 2) || print ("Could not lock $distFil: $!");
			my $contents  = <FILE>;
			my $email_reg = $email;
			$email_reg    =~ s/(\.|\@)/\\$1/g;
			$contents     =~ s/$email_reg//isg;
			truncate(FILE, length($contents));
			seek(FILE, 0, 0);
			print FILE  $contents;
			close(FILE);
			$/ = "\n";
		    } else {
			$tmpElements{'MESSAGE'} = $message{'MSG9'};
			$isError = 1;
		    }
		} else {
		    # Is back from Vacation so Add email entry in desc and delete entry from vacation table.
		    # Reference to stetement chop in get_dist_entry inside mailManager file add extra space with email.
		    my $temp_email = $email.' ';	
		    open(FILE, ">>$distFil") || print ("Can not open file $distFil: $!");
		    flock(FILE, 2) || print ("Could not lock $distFil: $!");
		    print FILE  $temp_email;
		    close(FILE);
		    my $sqlDelete = qq(Delete From `smartlist_vacation` WHERE `list` = '$list' AND `email_id` = '$email' AND `confirm_str` = '$confirm' AND `is_confirm` = 'Y' ) ;
		    my $rowsDeleted = $DBH->do( $sqlDelete );
		    $tmpElements{'MESSAGE'} = $message{'MSG11'};
		}
	    } else {
		$tmpElements{'MESSAGE'} = $message{'MSG8'};
		$isError = 1;
	    }
	}
    }
    
    
    #$emailForm = patchString($emailForm,\%patchElements);
    #$patchElements{MESSAGE} = $emailForm;
    #$tmpElements{HEAD}    = "On Vacation Request";
    #print $tmplStr;
    #print patchString($tmplStr,\%tmpElements);
    
    #print $tmpElements{'MESSAGE'};
}

# Check the submitted email in dist file (If not give message of email not in mailing list 
# or already on vacation else send confirmation mail to this ID and update the database).
if ( $ENV{'REQUEST_METHOD'} =~ /POST/i) {
    my ( $email, $list, $confirm ) = ( $query->param('email'),$query->param('list') );

    my($dom,$dummy)=split(/\./,$DOMAIN);
    my $listDir = '/home/'.$CPUSER.'/'.$dom.'-mail/'.$list;

    my $distFil = $listDir . '/' .'dist';
    
    if ($email =~ /^\s*$/){
	$tmpElements{'MESSAGE'} = $message{'MSG1'};
	$isError = 1;
    } elsif ($list =~ /^\s*$/){
	$tmpElements{'MESSAGE'} = $message{'MSG2'};
	$isError = 1;
    } elsif ( $email !~ /(.*?)@(.*?)\.(.*?)/ ){
	$tmpElements{'MESSAGE'} = $message{'MSG3'};
	$isError = 1;
    } elsif ( ( ! -d $listDir) && ( ! -e $distFil ) ) {
	$tmpElements{'MESSAGE'} = $message{'MSG4'};
	$isError = 1;
    } else {
	open FILE,"$distFil" || print "Failed to open dist file";
	local $/;
	my ($str,$val);
	$str = <FILE>;
	if ( $str =~ /$email/i) {
	    my $DBH = DBI->connect("dbi:mysql:$DATABASE:$HOST", "$DBUSER", "$DBPASS",
				   {RaiseError => 0, PrintError => 0} )
		or die("Cannot connect to the database");
	    
	    my $confirmStr = generate_random_string(10);
	    #Add request in confirmation database	
	    my $sql  = "INSERT INTO `smartlist_vacation` ( `list` , `email_id` , `confirm_str` , `is_confirm` )";
	    $sql .= "VALUES ('$list', '$email', '$confirmStr', 'N')";
	    
	    my $sth = $DBH->prepare( $sql );
	    $sth->execute();
	    
	    # MAIL the confirmation request to user.
	    
	    my $thisUrl  = 'http://'.$DOMAIN.'/cgi-bin/smartlist_vacation/vacation.cgi'; 
	    $thisUrl .= '?email='.$email.'&list='.$list.'&confirm='.$confirmStr;
	    my %mailElements;
	    $mailElements{'EMAIL'} = $email;
	    $mailElements{'THIS_CONFIRM_URL'} = $thisUrl;
	    $mailElements{'LIST'} = $list;
	    $mailContent = patchString($mailContent,\%mailElements);
	    
	    $patchElements{HEAD} = "Confirm on vacation request";
	    $patchElements{MESSAGE} = $mailContent;
	    $mailContent = patchString($tmplStr,\%patchElements);
 	    
	    ## To send HTML mail, you can set the Content-type header. 
	    my $headers  = "MIME-Version: 1.0\r\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	    
	    ## additional headers 
	    $headers .= "From: do not reply <donotreply@".$DOMAIN.">\r\n";
	    my $subject  = "Confirm on vacation request";
	    open(MAIL,"|/usr/lib/sendmail -t");
	    print MAIL "To: $email\n";
	    print MAIL "Subject: $subject\n";
	    print MAIL "$headers\n";
	    print MAIL "$mailContent\n";
	    close (MAIL);
	    #print $mailContent;
	    $tmpElements{'MESSAGE'} =  "Confirmation Mail is sent to you ";
	} else {
	    $tmpElements{'MESSAGE'} = $message{'MSG5'};
	    $isError = 1;
	}
    }
    
    #if ( $isError ) {	
#	$tmpElements{'LIST'}  = $query->param('list');
#	$tmpElements{'EMAIL'} = $query->param('email');
#	$emailForm = patchString($emailForm,\%tmpElements);
#	
#	$patchElements{MESSAGE} = $emailForm;
#        $patchElements{HEAD}    = "On Vacation Request";
#        #print $tmplStr;
#        print patchString($tmplStr,\%patchElements);
#	
#     } else {
#	 $patchElements{MESSAGE} = $tmpElements{'MESSAGE'};
#	 print patchString($tmplStr,\%patchElements);
#	 #print $tmpElements{'MESSAGE'};
#    }
}

if ( $isError ) {
    $tmpElements{'LIST'}  = $query->param('list');
    $tmpElements{'EMAIL'} = $query->param('email');
    $emailForm = patchString($emailForm,\%tmpElements);

    $patchElements{MESSAGE} = $emailForm;
    $patchElements{HEAD}    = "On Vacation Request";
        #print $tmplStr;
    print patchString($tmplStr,\%patchElements);

} else {
    $patchElements{MESSAGE} = $tmpElements{'MESSAGE'};
    print patchString($tmplStr,\%patchElements);
         #print $tmpElements{'MESSAGE'};
}
##################################################################
##
## Name : patchString
## ARG1 : String
## ARG2 : Hash Reference
## Desc : Function used for filling the empty values(#__VAL__#) in the string(1 st argument).
##        Values will be filled from hash ($hash{'VAL'})
##
##################################################################
sub patchString {
    my ($str,$hash_ref) = @_;
    my ($key,$val);	
    my @keys = keys %{$hash_ref};
    if ( $str !~ /^\s*$/ &&  scalar(@keys) ) {
        foreach $key ( @keys ) {
            $val = $hash_ref->{$key};
	    $str =~ s/#__($key)__#/$val/smg;
        }
    }
    $str =~ s/#__(.*?)__#//gs;
    undef $hash_ref; undef $val;
    return $str;
}

##################################################################
##
## Name : generate_random_string
## ARG1 : Number
## Desc : This function generates random strings of a given length
##
##################################################################

sub generate_random_string
{
	my $length_of_randomstring=shift;
	my @chars=('a'..'z','A'..'Z','0'..'9','_');
	my $random_string;
	foreach (1..$length_of_randomstring) 
	{
		$random_string.=$chars[rand @chars];
	}
	return $random_string;
}

exit;

