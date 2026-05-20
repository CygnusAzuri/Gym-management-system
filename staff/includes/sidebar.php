<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!--sidebar-menu-->
<div id="sidebar">
  <a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li class="<?php echo ($page=='dashboard') ? 'active' : ''; ?>">
      <a href="index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a>
    </li>
    <li class="<?php echo ($page=='member') ? 'submenu active' : 'submenu'; ?>">
      <a href="#"><i class="icon icon-group"></i> <span>Manage Members</span></a>
      <ul>
        <li><a href="members.php">List All Members</a></li>
        <li><a href="member-entry.php">Member Entry Form</a></li>
        <li><a href="remove-member.php">Remove Member</a></li>
        <li><a href="edit-member.php">Update Member Details</a></li>
      </ul>
    </li>

    <li class="<?php echo ($page=='equipment') ? 'submenu active' : 'submenu'; ?>">
      <a href="#"><i class="icon icon-cogs"></i> <span>Gym Equipment</span></a>
      <ul>
        <li><a href="equipment.php">List Gym Equipment</a></li>
        <li><a href="equipment-entry.php">Add Equipment</a></li>
        <li><a href="remove-equipment.php">Remove Equipment</a></li>
        <li><a href="edit-equipment.php">Update Equipment Details</a></li>
      </ul>
    </li>
    
    <li class="<?php echo ($page=='membersts') ? 'active' : ''; ?>">
      <a href="member-status.php"><i class="icon icon-eye-open"></i> <span>Member's Status</span></a>
    </li>
    <li class="<?php echo ($page=='payment') ? 'active' : ''; ?>">
      <a href="payment.php"><i class="icon icon-money"></i> <span>Payments</span></a>
    </li>
    <li class="<?php echo ($page=='attendance') ? 'active' : ''; ?>">
      <a href="attendance.php"><i class="icon icon-calendar"></i> <span>Manage Attendance</span></a>
    </li>
  </ul>
</div>
<!--sidebar-menu-->