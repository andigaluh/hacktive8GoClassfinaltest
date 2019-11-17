<!-- Page Header -->
  <header class="masthead" style="background-image: url('<?php echo base_url()?>theme/startbootstrap-clean-blog-master/img/contact-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1>Login</h1>
            <span class="subheading">Are you admin? please login.</span>
          </div>
        </div>
      </div>
    </div>
  </header>


<!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
      <p>Login : </p>
        <?php if($this->session->flashdata('success_message')) { echo '<div class="alert alert-success">'.$this->session->flashdata('success_message').'</div>'; }?>
        <?php if($this->session->flashdata('error_message')) { echo '<div class="alert alert-danger">'.$this->session->flashdata('error_message').'</div>'; }?>
        <form name="sentMessage" id="contactForm" novalidate action="<?php echo site_url('home/submit_login')?>" method="POST">
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Email Address</label>
              <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
              <?php echo form_error('email', '<p class="help-block text-danger">', '</p>'); ?>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Password</label>
              <input type="password" name="password" class="form-control" placeholder="Password" id="password" required data-validation-required-message="Please enter your password.">
              <?php echo form_error('password', '<p class="help-block text-danger">', '</p>'); ?>
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


