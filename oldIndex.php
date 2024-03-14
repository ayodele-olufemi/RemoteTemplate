<?php
$local = false;
$path = $_SERVER["DOCUMENT_ROOT"];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/header.php";
$menu = $path . "/includes/menu.php";
$footer = $path . "/includes/footer.php";
include($header);
include($menu);
?>
<h1>This is my First PHP template!</h1>

<h2>About Me</h2>
<img src="images/CI6A2271.jpg" style="width: 250px; float: left; margin-right: 30px" alt="" />
<p>
    Hi Everyone. I am Ayodele Olufemi (AY for short), a student at Metro State
    University. I'm from Nigeria. I moved to the USA in 2016 to study at Minnesota
    State University, Mankato. Prior to moving here, I had my Bachelors in
    Mathematics Education in 2009, worked for a bit in the banking industry before
    switching to teaching at a high school since 2012. <br />
    <br />
    I originally enrolled for MS Mathematics and Statistics at MSU Mankato, and
    while at it, I took some classes in IT and by the time I was done with my Math
    & Stat credits, I had just 12 credits left to earn another masters in IT, so I
    opted to earn it. As a Teaching Assistant at MSU, I taught College Algebra
    (MATH 112) where I had an average of 28 students in my class each semester for
    6 semesters.
    <br />
    <br />
    I was a Data and Application Architecture intern at Hennepin County Government
    Center for about 2 years, I've worked at Medtronics and I now work at Metro
    Transit as a Business Analyst. Most of my school and work experience in IT has
    been BI analysis and reporting, software development and database techologies,
    so when my visa status restrictions necessitate that I maintain my F1 status,
    I decided to have a feel of cybersecurity. <br />
    <br />
    I had hoped to resolve my visa issue within a year, so I enrolled at Saint
    Paul College rather than securing a PhD admission. At Saint Paul College, I
    was a Peer and PSEO tutor for mathematics and computer science classes.
    Unfortunately, resolving my visa issues is taking longer than expected, so
    here am I, on graduating with AAS cybersecurity at Saint Paul College,
    transfering to Metro State, with the Accelerated BS/MS Cybersecurity programe
    in mind, and hoping to have my immigration status resolved by the end of the
    program. <br />
    <br />
    I love watching soccer, teaching and everything DIY, especially car
    modifications. I love programming because it puts amazing powers in my hands,
    which for me is the equivalent of being a wizard — you want the machine to do
    something, write some lines of code and voila! Its done! My favorite quote is:
<figure>
    <blockquote class="blockquote">
        <p>Whatever is worth doing at all is worth doing well.</p>
    </blockquote>
    <figcaption class="blockquote-footer">
        Lord Chesterfield in
        <cite title="Source Title">Letters to His Son on the Art of Becoming a Man of the World and a
            Gentleman, 1752</cite>
    </figcaption>
</figure>
</p>

<?php
include($footer);
?>