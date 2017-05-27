<!DOCTYPE html>
<html>
	<head>
		<title>Shutterstock Tag Scraper</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h2>Shutterstock Tag Scraper</h2>
		<form action="index.php" method="get">
			<input type="text" name="url" id="url" placeholder="URL to page to scrape" />
			<input type="submit" />
		</form>
<?php
if (strlen($_GET['url']) > 0) {

    $url = $_GET['url'];
    echo '<h4>Your URL:</h4><a href="' . $url . '"><p>' . $url . '</p></a>';
    
    $ch = curl_init($url);
    $timeout = 5;
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    
    $html = curl_exec($ch);
    curl_close($ch);
    
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($dom);
    
    $nodes = $xpath->query("//a[contains(@class, 'btn-search-pill') and contains(@class, 'btn') and contains(@class, 'pull-left')]");
    //$nodes = $xpath->query("//a[@class='btn-search-pill']");
	// ^^^ old query that worked with the example but not with the actual application
    
    $links = array();
    
    foreach ($nodes as $i => $node) {
        $links[] = $node->nodeValue;
    }
    
    $links = array_unique($links);
    echo '<h4>The tags:</h4><p>';
    foreach ($links as $link) {
    	echo $link . ', ';
    }
    echo '</p>';

}

?>

	</body>
</html>