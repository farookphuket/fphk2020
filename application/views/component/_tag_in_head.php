<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="UTF-8">
<title><?php echo $meta_title;?></title>
<meta name="robots" content="noodp,noydir"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo $og_url;?>"/>
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $meta_title;?>" />
<meta property="og:description" content="<?php echo $page_description;?>" />
<meta name="description" content="<?php echo $page_description;?>"/>
<meta property="og:site_name" content="<?php echo $og_sitename;?>" />
<meta  name="keywords" content="<?php echo $page_keyword;?>">
<meta property="article:publisher" content="<?php echo $publisher; ?>" />
<link rel="canonical" href="<?php echo $og_url;?>" />

<link rel="icon"
      type="image/ico"
      href="<?php echo site_url('public/img/farICON.ico');?>" />



<!--last edit on 11-july-2019 4:05 p.m.-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



    <!--

    just comment this out when upload top the server
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    -->

    <!-- Plugin CSS -->
    <link href="<?php echo site_url("public/vendor/magnific-popup/magnific-popup.css");?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php //echo site_url("public/css/creative.min.css");?>" rel="stylesheet">

    <link href="<?php echo site_url("public/css/custom_theme.css");?>" rel="stylesheet">

<!--
   <script src="<?php //echo site_url("public/vendor/jquery/jquery.min.js");?>"></script>
-->
    <!--end of Sat 13 Oct 2018 -->

    <!--get the jQuery ui
    jquery.js
    jquery-ui.js
    jquery-ui.css
    -->

    <script src="<?php echo site_url("public/js/jquery-ui/jquery-ui.js");?>"></script>
    <link href="<?php echo site_url("public/js/jquery-ui/jquery-ui.css");?>" rel="stylesheet">

    <!--end of jQuery ui Mon 12 Nov 2018-->

<link rel="icon"
      type="image/ico"
      href="<?php echo site_url('public/img/farICON.ico');?>" />


<!-- Completly remove tinymce 19-3-2020 use Jodit instead-->

<!-- 22-Mar-2020 cannot use Jodit as it is server expire
<script src="https://xdsoft.net/jodit/node_modules/jodit/build/jodit.min.js?v=1522844281-3.3.23"></script>

<link rel="stylesheet" href="https://xdsoft.net/jodit/node_modules/jodit/build/jodit.min.css?v=1522844281-3.3.23">

-->

<link rel="stylesheet" href="<?php echo site_url("public/css/jodit.css"); ?>">
<script src="<?php echo site_url("public/js/jodit_main.js"); ?>"></script>
<script src="<?php echo site_url("public/js/jodit_index.js"); ?>"></script>


<!--
      <script src="<?php //echo site_url("public/js/tinymce/tinymce.min.js");?>"></script>


<script type="text/javascript">

tinymce.init({
    selector: "textarea.tinymce",
    height : 350,
    setup: function(editor){
        editor.on('change',function(){
            tinymce.triggerSave();
        });
    },
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table  paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>

-->

<!--test the cookies 7-July-2019-->
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
