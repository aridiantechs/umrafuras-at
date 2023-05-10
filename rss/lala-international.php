<pre>
        <?php
        $rss = simplexml_load_file('https://rss.app/feeds/anipEyZ4qaq8GgZJ.xml');
        $item = json_decode(json_encode($rss->channel->item), true);
        echo '<h2>' . $rss->channel->title . '</h2>';
        echo '<h4>Last Publish Date: ' . $item['pubDate'] . '</h4>';
        ?>
        </pre>