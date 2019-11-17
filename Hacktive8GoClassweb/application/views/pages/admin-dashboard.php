
<!-- Page Header -->
  <header class="masthead" style="background-image: url('<?php echo base_url()?>theme/startbootstrap-clean-blog-master/img/contact-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
      
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1>Welcome,</h1>
            <span class="subheading"><?php echo $this->session->userdata('user_name')?></span>
          </div>
        </div>
      </div>
    </div>
  </header>

    <!-- Main Content -->
  <div class="container">
    <div class="row">
    <?php $this->load->view('partials/sidebar')?>
      <div class="col-lg-8 col-md-10 mx-auto">
          <?php if($status == 1) { ?>
                    <p>This is dashboard page</p>
                <?php }else{ ?>
                    <h4>Data not found</h4>
                <?php }?>
        </div>
        </div>
    </div>    



    

