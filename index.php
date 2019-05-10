<?php
session_start();
$xml_filename = "opensearch_" . session_id() . ".xml";
if(isset($_GET["shortname"]) && isset($_GET["attr"])){
        touch($xml_filename);
        $datas = array(
                "shortname" => $_GET["shortname"],
                "searchaddr"=> $_GET["searchaddr"],
                "query"     => $_GET["attr"],
                "favicon"   => $_GET["favicon"],
        );
        $xmlcontent = array();
        $xmlcontent[0] = '<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">';
        $xmlcontent[1] = '<ShortName>'.htmlspecialchars($datas["shortname"]).'</ShortName>';
        $xmlcontent[2] = '<Image width="16" height="16">'.htmlspecialchars($datas["favicon"]).'</Image>';
                $xyz = $datas["searchaddr"].htmlspecialchars($datas["query"])."{searchTerms}";
        $xmlcontent[3] = '<Url type="text/html" method="GET" template="'.$xyz.'" />';
        $xmlcontent[4] = '</OpenSearchDescription>';
        $content = "";
        for($i= 0; $i < count($xmlcontent); $i++){
                $content = $content.$xmlcontent[$i] . "\n";
        }               
        $file = fopen($xml_filename, "w");
        fwrite($file, $content);
        echo "<script> alert('Opensearch XML file generated. You may now add your search engine.') </script>";
        fclose($file);
        @unlink($file);
} else {
        $datas = array(
                "shortname" => "",
                "searchaddr"=> "",
                "query"     => "",
                "favicon"   => "",
        );
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="generator" content="HTML Tidy for HTML5 for Linux version 5.6.0">
  <title>Opensearch.xml Generator</title><?php echo '<link rel="search" href="' . $xml_filename . '" type="application/opensearchdescription+xml" title="' . $datas['shortname'] . '">'; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
  <div class="jumbotron">
    <div class="container">
      <h1>Opensearch.xml Generator</h1>
      <form class="form-horizontal" name="setOSG" id="setOSG">
        <div class="ntbr">
          <div class="form-group">
            <label for="shortname" class="col-sm-2 control-label">Short name</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" required="" id="shortname" name="shortname" placeholder="ex: yoursite">
            </div>
            <script type="text/javascript">
            document.getElementById('shortname').value = '<?php echo $datas['shortname']; ?>';
            </script>
          </div>
          <div class="form-group">
            <label for="searchaddr" required="" class="col-sm-2 control-label">Search address</label>
            <div class="col-sm-4">
              <input type="url" class="form-control" required="" id="searchaddr" name="searchaddr" placeholder="ex: http://yoursite.com/search">
            </div>
            <script type="text/javascript">
            document.getElementById('searchaddr').value = '<?php echo $datas['searchaddr']; ?>';
            </script>
          </div>
          <div class="form-group">
            <label for="attr" class="col-sm-2 control-label">Search terms parameter</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="attr" name="attr" placeholder="ex: query (optional)"> <small>Example: yoursite.com/search<strong>?q=</strong>{searchTerms}</small>
            </div>
            <script type="text/javascript">
            document.getElementById('attr').value = '<?php echo $datas['query']; ?>';
            </script>
          </div>
          <div class="form-gruop">
            <label for="favicon" class="col-sm-2 control-label" style="width: 179px !important;">Favicon</label>
            <div class="col-sm-4">
              <input type="text" style="width: 361px;" class="form-control" id="favicon" name="favicon" placeholder="ex: yoursite.com/favicon.ico (optional)">
            </div>
            <script type="text/javascript">
            document.getElementById('favicon').value = '<?php echo $datas['favicon']; ?>';
            </script>
          </div><button type="submit" class="btn btn-default">Generate opensearch.xml.</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
