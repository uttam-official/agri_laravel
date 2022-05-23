<?php

use App\Http\Controllers\client\FunctionController;
?>
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <aside class="widget">
          <h4>Navigation</h4>
          <ul class="list-unstyled">
            <li><a href="<?= url('/') ?>">Home</a></li>
            <?php foreach (FunctionController::get_category() as $l) : ?>
              <li><a href="<?= url('cat/' . $l->slug_url) ?>"><?= $l->name ?></a></li>
            <?php endforeach; ?>
          </ul>
        </aside>
      </div>
      <div class="col-sm-4">
        <aside class="widget">
          <h4>CONTACT US</h4>
          <p><i class="fa fa-paper-plane"></i> &nbsp; Ballinahowen, Athlone, Co. Westmeath</p>
          <p style="font-size:18px;"><i class="fa fa-phone"></i> &nbsp; (090) 6430244</span></p>
          <i class="fa fa-envelope"></i> &nbsp; <a href="mailto:agriexpress@outlook.com"><em>agriexpress@outlook.com</em></a>
          <div class="social-link">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-rss"></i></a>
          </div>
        </aside>
      </div>
      <div class="col-sm-4">
        <aside class="widget">
          <h4>OPENING HOURS</h4>
          <p>Our opening hours are as follows:<br>
            Monday-Saturday: 9a.m. - 6p.m.<br>
            Sunday: Closed<br>
            Bank Holidays: Closed </p>
          <p><strong>WE ACCEPT</strong></p>
          <img src="{{asset('client/images/cart.png')}}" alt="">
        </aside>
      </div>
    </div>
  </div>
</footer>

<div class="footer-bottom">
  <div class="container">
    <div class="footer-logos"><img src="{{asset('client/images/logo-footer.png')}}" alt=""></div>
    <div class="copyright">Copyright 2016 agridirect | All Rights Reserved :: Department of Agriculture, Food and the Marine </div>
  </div>
</div>


<script>
  /*** add active class and stay opened when selected ***/
  var url = window.location;
  var server = window.location.origin;
  // for sidebar menu entirely but not cover treeview
  $('ul.nav a').filter(function() {
    if (this.href) {
      return this.href == url || (url.href.indexOf(this.href + '/') == 0);
    }
  }).addClass('active');
  //Dashboard
  window.location.href == server ? $('.home').addClass('active') : $('.home').removeClass('active');
</script>
<script>
  $(function() {
    $('.remove-cart').on('click',function(){
      const id=$(this).attr('data-id');
      $.ajax({
        url:"{{url('remove_cart')}}",
        type:'post',
        dataType:'json',
        data:{_token:'{{csrf_token()}}',id},
        success:function(data){
          if(data.status){
            toastr.error('Product removed from cart');
            location.reload();
          }
        },error:function(response){
          console.log({error:response});
        }
      })
    })
  })
</script>
@stack('js')
</body>

</html>