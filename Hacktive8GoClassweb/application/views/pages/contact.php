<!-- Page Header -->
  <header class="masthead" style="background-image: url('<?php echo base_url()?>theme/startbootstrap-clean-blog-master/img/contact-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1>Contact Me</h1>
            <span class="subheading">Have questions? I have answers.</span>
          </div>
        </div>
      </div>
    </div>
  </header>


  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon as possible!</p>
        <?php if($this->session->flashdata('success_message')) { echo '<div class="alert alert-success">'.$this->session->flashdata('success_message').'</div>'; }?>
        <?php if($this->session->flashdata('error_message')) { echo '<div class="alert alert-danger">'.$this->session->flashdata('error_message').'</div>'; }?>
        <form name="sentMessage" id="contactForm" novalidate action="<?php echo site_url('home/submit_contact')?>" method="POST">
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="Name" id="name" required data-validation-required-message="Please enter your name.">
              <?php echo form_error('name', '<p class="help-block text-danger">', '</p>'); ?>
              
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Email Address</label>
              <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
              <?php echo form_error('email', '<p class="help-block text-danger">', '</p>'); ?>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Message</label>
              <textarea rows="5" name="message" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <br>
          <div id="success"></div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" id="sendMessageButton">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  
