<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
    <title>Fancytree - Example</title>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <link href="https://www.jqueryscript.net/demo/jQuery-jQuery-UI-Dynamic-Tree-View-Plugin-Fancytree/src/skin-win8/ui.fancytree.css"
          rel="stylesheet" type="text/css">
    <script src="https://www.jqueryscript.net/demo/jQuery-jQuery-UI-Dynamic-Tree-View-Plugin-Fancytree/src/jquery.fancytree.js"
            type="text/javascript"></script>

    <!-- (Irrelevant source removed.) -->

    <script type="text/javascript">
        $(function () {
            // using default options
            $("#tree").fancytree();
        });
    </script>
</head>

<body class="example">
<h3>https://wwwendt.de/tech/fancytree/demo/#sample-select.html</h3>
<h3>https://www.jqueryscript.net/demo/Collapsible-Tree-View-Checkboxes-jQuery-hummingbird/</h3>
<div id="tree">
    <ul id="treeData" style="display: none;">
        <li id="id3" class="folder">Folder with some children
            <ul>
                <li id="id3.1">Sub-item 3.1
                    <ul>
                        <li id="id3.1.1"><input type="checkbox"> Sub-item 3.1.1</li>
                        <li id="id3.1.2"><input type="checkbox"> Sub-item 3.1.2</li>
                    </ul>
                </li>
                <li id="id3.2">Sub-item 3.2
                    <ul>
                        <li id="id3.2.1">Sub-item 3.2.1</li>
                        <li id="id3.2.2">Sub-item 3.2.2</li>
                    </ul>
                </li>
            </ul>
        <li id="id4" class="expanded">Document with some children (expanded on init)
            <ul>
                <li id="id4.1" class="active focused">Sub-item 4.1 (active and focus on init)
                    <ul>
                        <li id="id4.1.1">Sub-item 4.1.1
                        <li id="id4.1.2">Sub-item 4.1.2
                    </ul>
                </li>
                <li id="id4.2">Sub-item 4.2
                    <ul>
                        <li id="id4.2.1">Sub-item 4.2.1
                        <li id="id4.2.2">Sub-item 4.2.2
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>
<hr>
<div>
    <?php echo "<pre>";
    print_r($AccessLevels) ?>
</div>

<!-- (Irrelevant source removed.) -->
</body>
</html>