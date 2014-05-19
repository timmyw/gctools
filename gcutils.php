<?
function load_contacts($fname)
{
    $contacts = array();
    $fd = fopen($fname, 'r');
    if (!$fd) {
        print("Error opening:$infile\n");
        exit(-1);
    }

    $flds=0;
    while (($data = fgetcsv($fd, 1000, ',')) != FALSE) {
        if ($flds == 0) {
            $flds = $data;
            continue;
        }
        
        $contact=new stdClass;
        for ($i = 0; $i < count($flds); $i++) {
            $contact->{$flds[$i]} = $data[$i];
        }

        if ($contact->nickname == '' || $contact->nickname == 'None')
            $contact->nickname = strtolower(preg_replace('/[ -=]/', '.', $contact->name, -1));
        $ns = preg_split('/;/', $contact->email);
        $emails = array();
        foreach ($ns as $n) {
            $n = trim($n);
            $mc = new stdClass;
            $mc->cat='work';
            $mc->email = $n;
            if (strstr($n, ' ')) {
                list($mc->cat, $mc->email) = preg_split('/ /', $n);
            }
            $emails[] = $mc;
        }
        $ns = preg_split('/;/', $contact->phone);
        $phones = array();
        foreach ($ns as $n) {
            $phones[] = trim($n);
        }
        $contact->email = $emails;
        $contact->phone = $phones;
        $contacts[] = $contact;
    }
    fclose($fd);
    return $contacts;
}

?>
