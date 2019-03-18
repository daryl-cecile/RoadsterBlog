<?php

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
 
    <!-- Include external CSS. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet'>

    <!-- Include Editor style. -->
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/css/froala_style.min.css" rel="stylesheet" type="text/css" />

      <link rel='stylesheet' href="/resource/css/rizBlog.css">

  </head>
 
  <body>

    <div class="blog-roll">
        <div class="blog-roll-panel">
            <h2>Blog Roll</h2>
            <ul>
                <li>First Post Alert!</li>
                <li>Fancy Blog Name</li>
            </ul>
            <button></button>

        </div>
        
    </div>

    <div class="editor">

        <form action="save" method="POST">
            <h2 class="title">Title:</h2><br>
            <input type="text" class="title" title="title">

            <!-- Create a tag that we will use as the editable area. -->
            <!-- You can use a div tag as well. -->
            <textarea class="editor-content" title="content"></textarea>
            <button class="submit">Submit</button>
        </form>

    
        <!-- Include external JS libs. -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    
        <!-- Include Editor JS files. -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/js/froala_editor.pkgd.min.js"></script>
        <script type="text/javascript" src="/resource/js/RizBlog.js" defer></script>
        
    </div>
  </body>
</html>