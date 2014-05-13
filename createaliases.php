<?
require_once 'gcutils.php';

$opts=getopt('f:go:');
$infile = 'contacts.csv';
$outfile = 'aliases';
if (isset($opts['f']))
    $infile = $opts['f'];
if (isset($opts['o']))
    $outfile = $opts['o'];
if (isset($opts['g'])) {
    $x=`dlcontacts.sh $infile`;
}

$contacts = load_contacts($infile);

if (file_exists($outfile))
    unlink($outfile);

$done_emails = array();
foreach($contacts as $contact) {
    //var_dump($contact);
    if (!$contact->email[0]->email, $done_emails) {
        if (count($contact->email) > 1) {
            foreach ($contact->email as $e) {
                $em = preg_replace('/.*@/', '', $e->email);
            
                file_put_contents($outfile, 'alias '.$contact->nick.'.'.$em.' '.$contact->name.' <'.$contact->email[0]->email.">\n", FILE_APPEND);
            }
        } else {
            file_put_contents($outfile, 'alias '.$contact->nick.' '.$contact->name.' <'.$contact->email[0]->email.">\n", FILE_APPEND);
        }
        array_push($done_emails, $contact->email[0]->email);
    }
}

?>