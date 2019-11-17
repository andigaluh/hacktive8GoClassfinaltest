    <!-- Page Header -->
  <header class="masthead" style="background-image: url('<?php echo $data['image_url']?>')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1><?php echo $data['title']?></h1>
            <span class="subheading"><?php echo $data['subtitle']?></span>
            <div class="small">by : <?php echo $data['author']['nickname']?> @ : <?php echo date('d M Y H:i',strtotime($data['created_at']))?></div>
          </div>
        </div>
      </div>
    </div>
  </header>

    <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
          <?php if($status == 1) { ?>
                    <?php echo html_entity_decode($data['content'])?>
                <?php }else{ ?>
                    <h4>Data not found</h4>
                <?php }?>
        </div>
        </div>
    </div>    


    