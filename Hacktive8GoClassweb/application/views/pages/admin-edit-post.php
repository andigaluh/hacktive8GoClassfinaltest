

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
  <div class="container" style="font-size:14px;">
    <div class="row">
    <?php $this->load->view('partials/sidebar')?>
      <div class="col-lg-8 col-md-10 mx-auto">
      <p>Create a Post : </p>
      
        <?php if($this->session->flashdata('error_message')) { echo '<div class="alert alert-danger">'.$this->session->flashdata('error_message').'</div>'; }?>
        <?php if($this->session->flashdata('success_message')) { echo '<div class="alert alert-success">'.$this->session->flashdata('success_message').'</div>'; }?>
        <form name="sentMessage" id="contactForm" novalidate action="<?php echo site_url('home/adminUpdatePost/'.$data['id'])?>" method="POST" enctype="multipart/form-data">
        
          <div class="control-group">
            <div class="form-group ">
              <label>Image</label>
              <input type="file" name="userfile" size="20" class="form-control" id="image" placeholder="Upload image" />
              <label for="image">Preview</label><br/>
                <?php if(strlen($data['image_name']) > 0) { ?>
                    <img src="<?php echo $data['image_url']?>" alt="<?php echo $data['image_name']?>" width="200px">
                <?php } ?>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group ">
              <label>Title</label>
              <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="<?php echo $data['title']?>">
              
              <?php echo form_error('title', '<p class="help-block text-danger">', '</p>'); ?>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group ">
              <label>Subtitle</label>
              <input type="text" class="form-control" id="subtitle" placeholder="Enter subtitle" name="subtitle" value="<?php echo $data['subtitle']?>">
              <?php echo form_error('subtitle', '<p class="help-block text-danger">', '</p>'); ?>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group ">
              <label>Content</label>
             <textarea class="form-control" name="content" id="summernote" cols="30" rows="10"><?php echo $data['content']?></textarea>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group controls">
              <label>Publish</label>
              <select name="is_publish" id="is_publish" class="form-control">
                <option value="0" <?php if($data['is_publish'] == 0) { echo 'selected'; }?> >NotPublish</option>
                <option value="1" <?php if($data['is_publish'] == 1) { echo 'selected'; }?> >Publish</option>
              </select>
            </div>
          </div>
          <br>
          <div id="success"></div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" id="sendMessageButton">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>


    