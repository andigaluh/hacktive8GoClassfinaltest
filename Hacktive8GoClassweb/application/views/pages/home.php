    <!-- Page Header -->
  <header class="masthead" style="background-image: url('<?php echo base_url()?>theme/startbootstrap-clean-blog-master/img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Ghanbiyan Blog</h1>
            <span class="subheading">A Blog by Ghanbiyan</span>
          </div>
        </div>
      </div>
    </div>
  </header>
  
  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <?php foreach ($data as $key => $value) { ?>
        <div class="post-preview">
          <a href="<?php echo site_url('home/detail/'.$value['id'])?>">
            <h2 class="post-title">
              <?php echo $value['title']?>
            </h2>
            <h3 class="post-subtitle">
              
                <?php echo word_limiter($value['subtitle'], 4);?>
            </h3>
          </a>
          <p class="post-meta">Posted by
            <a href="#"><?php echo $value['author']['nickname']?></a>
            on <?php echo date('M d, Y ',strtotime($value['created_at']))?></p>
        </div>
        <hr>
        <?php } ?>
        <!-- Pager -->
        <!-- <div class="clearfix">
          <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
        </div> -->
      </div>
    </div>
  </div>
    

    