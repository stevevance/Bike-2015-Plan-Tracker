<table>

<?php foreach ($strategies as $strategy): ?>
  <tr>
    <td><?php echo anchor('strategies/view/'.$strategy['id'], $strategy['id']) ?></td>
    <td><?php echo $strategy['strategyTitle'] ?></td>
    <td><?php echo $strategy['strategyBody'] ?></td>
    <?php //print_r($strategy) ?>
    <!-- <h2><?php echo $news_item['title'] ?></h2>
        <div id="main">
            <?php echo $news_item['text'] ?>
        </div>
        <p><a href="news/<?php echo $news_item['slug'] ?>">View article</a></p> -->
  </tr>
<?php endforeach ?>

</table>