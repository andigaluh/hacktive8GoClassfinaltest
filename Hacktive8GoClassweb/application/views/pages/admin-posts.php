
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
<div class="container" style="font-size:14px">
    <div class="row">
    <?php $this->load->view('partials/sidebar')?>
        <div class="col-lg-8 col-md-10 mx-auto">
        <?php if($this->session->flashdata('success_message')) { echo '<div class="alert alert-success">'.$this->session->flashdata('success_message').'</div>'; }?>
        <?php if($this->session->flashdata('error_message')) { echo '<div class="alert alert-danger">'.$this->session->flashdata('error_message').'</div>'; }?>
        <a href="<?php echo site_url('adminCreatePost')?>"><button type="button" class="btn btn-primary">Add New</button></a>

        <?php if($status == TRUE) { ?>
            <table class="table table-bordered" >
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Is publish</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($data as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value['id']?></td>
                        <td><?php echo $value['title']?></td>
                        <td><?php echo $value['is_publish']?></td>
                        <td><?php echo $value['author']['nickname']?></td>
                        <td><?php echo date('d M Y H:i:s',strtotime($value['created_at']))?></td>
                        <td><a href="<?php echo site_url('adminPost/'.$value['id'])?>">Edit</a> | <a href="<?php echo site_url('adminDeletePost/'.$value['id'])?>">Delete</a></td>
                    </tr>
                <?php } ?>
            </table>
        <?php }else{ ?>
            <p>Data not found</p>
        <?php } ?>


        </div>
    </div>
</div>