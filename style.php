/**** 
* AMP Framework Reset
*****/
    body{ font-family: sans-serif; font-size: 16px; line-height:1.4; }
    ol, ul{ list-style-position: inside }
    p, ol, ul, figure{ margin: 0 0 1em; padding: 0; }
    a, a:active, a:visited{ color:#ed1c24; text-decoration: none }
    a:hover, a:active, a:focus{}
    pre{ white-space: pre-wrap;}
    .left{float:left}
    .right{float:right}
    .hidden{ display:none }
    .clearfix{ clear:both }
    blockquote{ background: #f1f1f1; margin: 10px 0 20px 0; padding: 15px;}
    blockquote p:last-child {margin-bottom: 0;}
    .amp-wp-unknown-size img {object-fit: contain;}
    .amp-wp-enforced-sizes{ max-width: 100% }
    /* Image Alignment */
    .alignright {
        float: right;
    }
    .alignleft {
        float: left;
    }
    .aligncenter {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    amp-iframe { max-width: 100%; margin-bottom : 20px; }

    /* Captions */
    .wp-caption {
        padding: 0;
    }
    .wp-caption-text {
        font-size: 12px;
        line-height: 1.5em;
        margin: 0;
        padding: .66em 10px .75em;
        text-align: center;
    }

    /* AMP Media */
    amp-iframe,
    amp-youtube,
    amp-instagram,
    amp-vine {
        margin: 0 -16px 1.5em;
    }
    amp-carousel > amp-img > img {
        object-fit: contain;
    }


/****
* Container
*****/
.container {
    max-width: 600px;
    margin: 0 auto;
}

/****
* AMP Sidebar
*****/
    amp-sidebar {
        width: 250px;
    }

    /* AMP Sidebar Toggle button */
    .amp-sidebar-button{
        position:relative;
    }
    .amp-sidebar-toggle  {
    }
    .amp-sidebar-toggle span  {
        display: block;
        height: 2px;
        margin-bottom: 5px;
        width: 22px;
        background: #000;
    }
    .amp-sidebar-toggle span:nth-child(2){
        top: 7px;
    }
    .amp-sidebar-toggle span:nth-child(3){
        top:14px;
    }

    /* AMP Sidebar close button */
    .amp-sidebar-close{
        background: #333;
        display: inline-block;
        padding: 5px 10px;
        font-size: 12px;
        color: #fff;
    }

/****
* AMP Navigation Menu with Dropdown Support
*****/
    .toggle-navigation ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: inline-block;
        width: 100%
    }
    .toggle-navigation ul li{
        font-size: 13px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.11);
        padding: 11px 0px;
        width: 25%;
        float: left;
        text-align: center;
        margin-top: 6px
    }
    .toggle-navigation ul ul{
        display: none
    }
    .toggle-navigation ul li a{
        color: #eee;
        padding: 15px;
    }
    .toggle-navigation{
        display: none;
        background: #444;
    }


/**** 
* Header
*****/
.amp-logo {
    width:190px;
    height:36px;
}
    .header h1{
        font-size: 1.5em;
    }
    .header .right{
        margin: 16px 5px 0px 5px;
    }
    .amp-phone, .amp-social, .amp-sidebar-button{
        display:inline-flex 
    }
    .amp-phone{
        top: 4px;
    }
    .header .amp-social{
        margin: 0px 19px;
    }
    .amp-sidebar-button{
        top: 6px;
    }


/**** 
* Loop
*****/
    .loop-post{
        display: inline-block;
        width: 100%;
        margin: 6px 0px;
    }
    .loop-post .loop-img{
        float: left;
        margin-right: 15px;
    }
    .loop-post h2{
        font-size: 1.2em;
        margin: 0px 0px 8px 0px;
    }
    .loop-post p{
        font-size: 14px;
        color: #333;
        margin-bottom:6px;
    }
    .loop-post ul{
        list-style-type: none;
        display: inline-flex;
        margin: 0px;
        font-size: 14px;
        color: #666;
    }
    .loop-post ul li{
        margin-right:2px;
    }
    .loop-date{
        font-size:12px;
    }


/****
* Single
*****/
    /** Related Posts **/
    .amp-related-posts ul{
        list-style-type:none;
    }
    .amp-related-posts ul li{
        display: inline-block;
        line-height: 1.3;
        margin-bottom: 5px;
    }
    .amp-related-posts amp-img{
        float: left;
        width: 100px;
        margin: 0px 10px 0px 0px;
    }


/**** 
* Comments
*****/
	.comments_list ul{
	    margin:0;
	    padding:0
	}
	.comments_list ul.children{
	    padding-bottom:10px;
		margin-left: 4%;
		width: 96%;
	}
	.comments_list ul li p{
        margin: 0;
        font-size: 14px;
        clear: both;
        padding-top: 5px;
	}
    .comments_list ul li .says{
        margin-right: 4px;
    }
	.comments_list ul li .comment-body{
	    padding: 10px 0px 15px 0px;
	}
	.comments_list li li{
	    margin: 20px 20px 10px 20px;
	    background: #f7f7f7;
	    box-shadow: none;
	    border: 1px solid #eee;
	}
	.comments_list li li li{
	    margin:20px 20px 10px 20px
	}
	.comment-author{ float:left }


/**** 
* Footer
*****/
    .footer{
        padding: 30px 0px 20px 0px;
        font-size: 12px;
        text-align: center;
    }
    amp-carousel figcaption amp-fit-text {
        max-height: 200px;
        overflow-y: auto;
    }
    #gallery-images .amp-carousel-button {
        top: 24%;
    }
    figcaption .credit {
        font-family: "Open Sans", Helvetica, sans-serif;
        color: #686c73;
        font-size: 11px;
        margin-left: 0px;
        padding-left: 8px;
    }
    figcaption h2 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.2em;
        margin-top: 0.3em;
        letter-spacing: 0.3px;
    }

    figcaption .slide-info .counter {
        font-family: "Open Sans", Helvetica, sans-serif;
        font-size: 12px;
        font-style: italic;
        font-weight: 700;
    }

    h1.amp-post-title {
        font-family: "Merriweather", Times, serif;
        font-weight: 700;
        font-size: 24px;
        line-height: 30px;
    }

    .header .left {
        margin: 16px 0 0 35%;
    }

    .header .amp-logo h1 { display: none; }
    .header .amp-logo {
        width: auto;
    }
amp-carousel {
  margin-bottom: 10px;
}

.caption {
  padding: 0 10px;
}

.scroll-box {
  max-height: 180px;
  overflow-y: scroll;
  background: azure;
  padding-right: 1vw;
}

.amp-ad-wrapper amp-ad {
    margin: 4px auto; 
    display: block;
}
/****
* RTL Styles
*****/
    <?php  if( is_rtl() ) {?> <?php } ?>
