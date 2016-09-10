<?php
/**
 * @file
 * Theme implementation to display a single Drupal page.
 */
?>
<?php if ($page['utility']): ?>
<?php print render($page['utility']); ?>
<?php endif; ?>

<?php if ($page['header']): ?>
<?php print render($page['header']); ?>
<?php endif; ?>

<?php if ($page['navigation']): ?>
  <?php print render($page['navigation']); ?>
<?php endif; ?>

<?php if ($page['highlighted']): ?>
  <?php print render($page['highlighted']); ?>
<?php endif; ?>

<?php if ($page['preface']): ?>
  <?php print render($page['preface']); ?>
<?php endif; ?>


<?php if ($page['content']): ?>
<main class="main region--main" role="main">
  <?php print render($page['content']); ?>
</main>
<?php endif; ?>

<?php if (!empty($page['sidebar_first'])): ?>
<aside role="complementary" class="sidebar sidebar-first">
  <?php print render($page['sidebar_first']); ?>
</aside>
<?php endif; ?>

<?php if (!empty($page['sidebar_second'])): ?>
<aside role="complementary" class="sidebar sidebar-second">
  <?php print render($page['sidebar_second']); ?>
</aside>
<?php endif; ?>


<?php if ($page['postscript']): ?>
  <?php print render($page['postscript']); ?>
<?php endif; ?>

<?php if ($page['footer']): ?>
<footer class="footer" role="contentinfo">
  <?php print render($page['footer']); ?>
</footer>
<?php endif; ?>
