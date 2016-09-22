<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<div id='about'>
<h1>About Project</h1>
<br><br>
<p>
    <h2>Foreword</h2>
    <p>Dear reader all the materials used to generate this project were obtained
        from the Internet on rights as is. The aim of project - only demonstration
        and no way commercial activity. If you find an error on the site please 
        contact me via email orionla2@gmail.com.</p>
    <br><hr><br>
    <h2>Task</h2>
    <ul>
        <li>
            to create a responsive policymaking site based on a template;
        </li>
        <li>
            site theme: Catalogue of books;
        </li>
        <li>
            design a MySQL database;
        </li>
        <li>
            initial data: name of the book, book's photo, book's authors, date of
    publishing, address of publisher, telephone number of publisher, book category; 
        </li>
        <li>
            The work must be carried out using Yii 1.1.16;
        </li>
        <li>
            The program should run on Unix and Windows server;
        </li>
        <li>
            Observe that the program can be located anywhere in the file structure;
        </li>
        <li>
            The program should run on php error_reporting(E_ALL);
        </li>
        <li>
            design CRUD: publisher, author, book, category;
        </li>
        <li>
            Categories should be hierarchical;
        </li>
        
    </ul>
    <hr><br>
    <h2>What has been realized</h2>
    <ul>
        <li>http://www.ftemplate.ru/Templa/templatemo_086_book_store.zip template was selected.</li>
        <li>downloaded and installed Yii 1.1.16.</li>
        <li>The DB developed such way that you can easily expand the types of goods or even 
    change their nature.</li>
        <li>login system was transfered into a system of user roles and tied to BD.</li>
        <li>admin module for backend implemented and finalized the standard module site for frontend.</li>
        <li>extensions:
            <ul>
                <li>Uploaded from internet
                    <ul>
                        <li>ckeditor</li>
                    </ul>
                </li>
                <li>My custom widgets
                    <ul>
                        <li>WidgetGridView (front views and filter)</li>
                        <li>JuiMenuWidget (side menu)</li>
                        <li>ProductViewWidget (admin/product/ create & update forms)</li>
                        <li>ItemViewWidget (create & update forms in CRUD excluding category and product)</li>
                        <li>ExtendedFilters (extend filters for WidgetGridView)</li>
                        <li>Money (class for handling price view on page and converting for DB)</li>
                        <li>PictureConvertor (manage picture transfers and storing in BD)</li>
                        <li>ProductSlider (slide pictures for products,authors,publishers)</li>
                    </ul>
                </li>
            </ul>
        <li>CRUD: all update & create request are handling with rollback, 
                    delete functions are hidden and available for Admin group of 
                    users(currently delete is avail only from URL).</li>
        </li>
        <li>User managment available only for authorised as Admin users.</li>
    </ul>
    <hr><br>
    <h2>Features</h2>
        <span>&nbsp&nbsp&nbsp&nbsp <text>WidgetGridView</text> - variation of CGridView, it's handling all search requests
        via AJAX as CGridView in case of current category and showing result as 
        bunch of products.</span><br>
        <span>&nbsp&nbsp&nbsp&nbsp <text>JuiMenuWidget</text> - It was created because inside of Yii::jQuiryUI not realised 
        menu, but jQuiry UI has such abbility and it's perfectly match for submenu.</span><br>
        <span>&nbsp&nbsp&nbsp&nbsp <text>ProductViewWidget</text> - specialy created for product creat and update form. Main
        feature is dropable form for pictures. It consist of dropzone/preview and 
        slider with small clickable icons of uploaded pictures, on click of this 
        icons it will show pictures in preview block. Also this picture slider has 
        ability to remove pictures. Another interesting posibility is multiple
        select for authors and categories. For description at this widget used 
        ckeditor extension which makes text input much comfortable. Since delete
        function is disabled you can't delete product, but you can make it 
        unavailable via checkbox.</span><br>
        <span>&nbsp&nbsp&nbsp&nbsp <text>ItemViewWidget</text> - little bit liter version of ProductViewWidget specified
        for needs of author and publisher CRUDs.
        ProductSlider: making all pictures clickable for sliding if product/item
        has few pictures in description.</span><br><br>
    <hr><br>
    <h2>What would be nice to add</h2>
    <ul>
        <li>Convert all pictures into the one resolution before save it to the temp folder. It 
    will improve picture rendering speed and make senese for using view forms.</li>
        <li>Cash MySQL requests improve response speed aproximatly on 30%.</li>
        <li>Improve login system with hash.</li>
    </ul>
    <hr><br>
    <h2>Summary</h3>
    Please keep in mind that it's my first Yii project.
    I spent 14 hours to learn Yii and create an easiest blog.
    To develop this project with all components I spent 107 hours.
    
</p>
</div>