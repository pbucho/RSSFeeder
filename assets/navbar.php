<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once($DOC_ROOT."/api/funcs/func_get_user.php");
?>
<div id="navbar" class="navbar navbar-default ace-save-state">
  <div class="navbar-container ace-save-state" id="navbar-container">
    <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
      <span class="sr-only">Toggle sidebar</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <div class="navbar-header pull-left">
      <a href="index.html" class="navbar-brand">
        <small>
          <i class="fa fa-rss"></i>
          RSS Feeder
        </small>
      </a>
    </div>
    <div class="navbar-buttons navbar-header pull-right" role="navigation">
      <ul class="nav ace-nav">
        <li class="light-blue dropdown-modal">
          <a data-toggle="dropdown" href="#" class="dropdown-toggle">
            <img class="nav-user-photo" src="/assets/images/avatars/avatar5.png" />
            <span class="user-info">
              <small>Welcome,</small>
              <?php echo json_decode(api_get_user($_COOKIE['token']), true)['username']; ?>
            </span>
            <i class="ace-icon fa fa-caret-down"></i>
          </a>
          <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li>
              <a href="profile.html">
                <i class="ace-icon fa fa-user"></i>
                Profile
              </a>
            </li>
            <li class="divider"></li>
            <li>
              <a href="#">
                <i class="ace-icon fa fa-power-off"></i>
                Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div><!-- /.navbar-container -->
</div>