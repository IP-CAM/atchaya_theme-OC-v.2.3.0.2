<!-- <div class="col-lg-3 col-md-3 vermagemenu-container"> -->
<div class="vermagemenu-container">
<div class="vermagemenu visible-lg visible-md">
    <div class="content-vermagemenu"> 
        <!-- <h2><i class="fa fa-align-justify"></i><?php echo $heading_title;?></h2> -->
        <div class="navleft-container">
            <div id="pt_vmegamenu" class="pt_vmegamenu">
                <?php echo $vermegamenu ?> 
            </div>	
        </div>
    </div>
</div>
</div>
<!-- <script type="text/javascript">
//<![CDATA[
var CUSTOMMENU_POPUP_EFFECT = <?php echo $effect; ?>;
var CUSTOMMENU_POPUP_TOP_OFFSET = <?php echo $top_offset ; ?>
//]]>
        $('.vermagemenu h2').click(function () {
            $( ".navleft-container" ).slideToggle();
			$(this).toggleClass('no-padding');
			$('.content-vermagemenu').toggleClass('small-padding');
        });
</script> -->

<style>
.accordion {
  width: 100%;
  margin: 0px;
  background: #FFF;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  padding:0px;
  margin:0px;
  border:1px solid #ccc;
}
.accordion li
{
    list-style:none;
}
.accordion .link {
  cursor: pointer;
  display: block;
  padding: 15px 15px 15px 15px;
  color: #4D4D4D;
  font-size: 14px;
  font-weight: 700;
  border-bottom: 1px solid #CCC;
  position: relative;
  -webkit-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
}

.accordion li:last-child .link { border-bottom: 0; }

.accordion li i {
  position: absolute;
  top: 16px;
  left: 12px;
  font-size: 18px;
  color: #595959;
  -webkit-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
}

.accordion li i.fa-chevron-down {
  right: 12px;
  left: auto;
  font-size: 16px;
}

.accordion li.open .link { color: #b63b4d; }

.accordion li.open i { color: #b63b4d; }

.accordion li.open i.fa-chevron-down {
  -webkit-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  -o-transform: rotate(180deg);
  transform: rotate(180deg);
}
.submenu {
  display: none;
  background: #444359;
  font-size: 14px;
  padding:0px;
  margin:0px;
}

.submenu li {
    list-style:none;
    border-bottom: 1px solid #4b4a5e;
     }

.submenu a {
  display: block;
  text-decoration: none;
  color: #d9d9d9;
  padding: 12px;
  -webkit-transition: all 0.25s ease;
  -o-transition: all 0.25s ease;
  transition: all 0.25s ease;
}


</style>

<!-- <ul id="accordion" class="accordion">
  <li>
    <div class="link">Web Design<i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="#">Photoshop</a></li>
      <li><a href="#">HTML</a></li>
      <li><a href="#">CSS</a></li>
    </ul>
  </li>
  <li>
    <div class="link">Coding<i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="#">Javascript</a></li>
      <li><a href="#">jQuery</a></li>
      <li><a href="#">Ruby</a></li>
    </ul>
  </li>
  <li>
    <div class="link">Devices<i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="#">Tablet</a></li>
      <li><a href="#">Mobile</a></li>
      <li><a href="#">Desktop</a></li>
    </ul>
  </li>
  <li>
    <div class="link">Global<i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="#">Google</a></li>
      <li><a href="#">Bing</a></li>
      <li><a href="#">Yahoo</a></li>
    </ul>
  </li>
</ul> -->
<!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>  -->
<script>
$(function() {
    var Accordion = function(el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;

        // Variables privadas
        var links = this.el.find('.link');
        // Evento
        links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
    }

    Accordion.prototype.dropdown = function(e) {
        var $el = e.data.el;
            $this = $(this),
            $next = $this.next();

        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        };
    }   

    var accordion = new Accordion($('#accordion'), false);
});
</script>