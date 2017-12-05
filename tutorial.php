<?php
include('top.php')
?>
<!-- ----------------------------------------------------------------------- -->
<article class="tutorial">
    <?php
    include 'top.php';
    ?>
    <p class="oneTutorial">
        Things you will need:
    </p>
    
    <ul class="unordered">
        <li>ImageJ (for respective OS)</li>
        <li>R B & G Images (OR H-alpha, OIII, & SII)</li>
        <li>Patience</li>
    </ul>
    
    <p class="twoTutorial">
        Before starting, do “Save As” on the images and save them as .TIFF files 
        with new names. Save them regularly to guarantee that the originals, 
        and your progress, are not lost.
    </p>
    
    
    <ol>
        <li class="thelist">Open the TIFF files of the same object. To open (if all three 
            images are in the same folder), click “File > Import > Image 
            Sequence” and click on the first image then click “Open” and they 
            will be automatically loaded as a stack. If all three images are in 
            different places, click on the original menu bar in the upper left 
            corner on “File > Open >” and then find all three files (R, G, & B 
            or H-alpha, OIII, & SII).</li>
        <li class="thelist">Now to check the brightness. Go to “Image > Adjust > Brightness/Contrast”. 
            When on the red slice/image, use the “Maximum” slider to tweak. The 
            image should be bright enough to where every star/object possible 
            is visible, but they aren’t creating glare.</li>
        <ol type="a">
            <li class="thelist">OPTIONAL: If needed (for higher quality), convert the images 
            into 32-bit images before the next few steps. You can do this by 
            going to “Image > Type > 32 Bit”.</li>
        </ol>
        <li class="thelist">If the images are already stacked: Go to “Image > Stacks > Stack to 
            Images”.</li>
        <li class="thelist">Now repeat Step 2 for all of the images. Be sure to maintain a dark 
            sky, while still bringing out the image (don’t move the maximum 
            slider more than halfway). Do not spend too long on this step, fine 
            adjustments come later.</li>
        <li class="thelist">For each image, go to “Process > Math > Log”. This applies a 
            logarithmic stretch to increase the range of pixel values. After 
            doing this, the image will disappear, but don’t worry. Go to the 
            “Brightness/Contrast” slider again and drag “Minimum” back to zero 
            and the image will reappear.</li>
        <ol type="a">
            <li class="thelist">If you previously converted the images to 32-bit, you now need 
                to change them back to 16-bit. Go to “Image > Type > 16 Bit”.</li>
        </ol>
        <li class="thelist">Now to merge the images. To merge the images, go to 
            “Image > Color > Merge Channels”. Be sure to order the red, green, 
            and blue (and sometimes luminosity(grey)) images into the proper 
            channel. When selecting the proper channels, be sure to check the 
            check box that says, “Make composite”.</li>
        <ol type="a">
            <li class="thelist">If the images you have are H-alpha, OIII, and SII, then you 
                will see there are no channels labelled that way. H-alpha, OIII,
                and SII match up to Red, Green, and Blue respectively 
                (most of the time). If this order doesn’t work, use this link to
                figure out which order to use: 
                https://starizona.com/acb/ccd/advimnarrow2.aspx.</li>
            <li>Save this new composite</li>
        </ol>
        <li class="thelist">Check the alignment of the images. To do this zoom in on the 
            image by using either the “+” key or the magnifying glass tool. Zoom 
            far enough on a single star that you can see the pixels. If you can 
            see the separate colors in the star, you need to align the images.</li>
        <ol type="a">
            <li class="thelist">a. To align the images, select the red slice. Do ctrl-a on the 
                keyboard (command-a if Mac). This copies the whole image. Now do
                ctrl-x (command-x) to cut the image. The red will disappear, but
                simply do ctrl-v (command-v) and it will paste the image back. 
                Now use the arrow keys to move the image and try to center it in
                the star. Once you have done this, proceed to the next slice.</li>
        </ol>
        <li class="thelist">Despeckle the image if you so desire. This will remove any hot 
            pixels from the image, enhancing the look. To do this, go to 
            “Process > Noise > Despeckle”.</li>
        <li class="thelist">Now for the colorful part. Go to “Image > Adjust > Color Balance”. 
            Choose which channel to adjust and use the “Minimum” and “Maximum” 
            sliders to produce an image that suits you. Do this for each channel
            individually. NOTE: Be sure to use a gentle touch on the sliders, 
            preferably using the arrows instead of the slide bar. This part 
            takes time and will produce an image based on the amount of time you
            put in.</li>
        <li class="thelist">In order for other programs to be able to access the file, do 
            “Image > Type > RGB Color”.</li>
        <li class="thelist">Finally, “Save As” a TIFF file. If you plan to share the image 
            online, also “Save As” a .jpeg.</li>
    </ol>
    
    
    
    
    <?php
    include('footer.php');
    ?>
</article>
    </body>
</html>

