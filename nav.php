<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        
        print '<li class="';
        if ($path_parts['filename'] == "home") {
            print ' activePage ';
        }
        print '">';
        print '<a href="home.php">Home</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "intro") {
            print ' activePage ';
        }
        print '">';
        print '<a href="intro.php">Introduction</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "tutorial") {
            print ' activePage ';
        }
        print '">';
        print '<a href="tutorial.php">Tutorial</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "gallery") {
            print ' activePage ';
        }
        print '">';
        print '<a href="gallery.php">Gallery</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "about") {
            print ' activePage ';
        }
        print '">';
        print '<a href="about.php">About</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "form") {
            print ' activePage ';
        }
        print '">';
        print '<a href="form.php">Join</a>';
        print '</li>';
        ?>
    </ol>
</nav>
