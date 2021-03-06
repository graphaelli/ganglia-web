<?php

$base_dir = dirname(__FILE__);
ini_set( 'include_path', ini_get('include_path').":$base_dir/../lib");
require_once 'GangliaAcl.php';

/**
 * Test class for GangliaAcl.
 * Generated by PHPUnit on 2011-04-20 at 20:35:07.
 */
class GangliaAclTest extends PHPUnit_Framework_TestCase {
  
    protected function setUp() {
        $this->object = new GangliaAcl;
    }
    
    // This is the normal way to access the ACL.
    public function testGetInstance() {
      $obj1 = GangliaAcl::getInstance();
      $obj2 = GangliaAcl::getInstance();
      
      $this->assertEquals( $obj1, $obj2 );
    }
    
    public function testGuestCanViewNormalClusters() {
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::GUEST, GangliaAcl::ALL_CLUSTERS, GangliaAcl::VIEW ) );
    }
    
    public function testAdminCanViewNormalClusters() {
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::ADMIN, GangliaAcl::ALL_CLUSTERS, GangliaAcl::VIEW ) );
    }
    
    public function testGuestCannotEdit() {
      $this->assertFalse( $this->object->isAllowed( GangliaAcl::GUEST, GangliaAcl::ALL_CLUSTERS, GangliaAcl::EDIT ) );
    }
    
    public function testAdminCanEdit() {
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::ADMIN, GangliaAcl::ALL_CLUSTERS, GangliaAcl::EDIT ) );
    }
    
    public function testAdminCanAccessPrivateCluster() {
      $this->object->addPrivateCluster( 'clustername' );
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::ADMIN, 'clustername', GangliaAcl::VIEW ) );
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::ADMIN, 'clustername', GangliaAcl::EDIT ) );
    }
    
    public function testGuestCannotAccessPrivateCluster() {
      $this->object->addPrivateCluster( 'clustername' );
      $this->assertFalse( $this->object->isAllowed( GangliaAcl::GUEST, 'clustername', GangliaAcl::VIEW ) );
      $this->assertFalse( $this->object->isAllowed( GangliaAcl::GUEST, 'clustername', GangliaAcl::EDIT ) );
    }
    
    public function testGuestCanViewNormalCluster() {
      $this->object->add( new Zend_Acl_Resource('clustername'), GangliaAcl::ALL_CLUSTERS );
      $this->object->addRole( 'username', GangliaAcl::GUEST );
      $this->object->allow( 'username', 'clustername', array(GangliaAcl::EDIT, GangliaAcl::VIEW) );
      
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::GUEST, 'clustername', GangliaAcl::VIEW ) );
    }
    
    public function testUserMayBeGrantedViewAccessToPrivateCluster() {
      $this->object->addPrivateCluster( 'clustername' );
      $this->object->addRole( 'newuser', GangliaAcl::GUEST );
      $this->object->allow( 'newuser', 'clustername', GangliaAcl::VIEW );
      
      $this->assertTrue( $this->object->isAllowed( 'newuser', 'clustername', GangliaAcl::VIEW ) );
      $this->assertFalse( $this->object->isAllowed( 'newuser', 'clustername', GangliaAcl::EDIT ) );
    }
    
    public function testUserMayBeGrantedEditAccessToPrivateCluster() {
      $this->object->addPrivateCluster( 'clustername' );
      $this->object->addRole( 'newuser', GangliaAcl::GUEST );
      $this->object->allow( 'newuser', 'clustername', array( GangliaAcl::VIEW, GangliaAcl::EDIT ) );
      
      $this->assertTrue( $this->object->isAllowed( 'newuser', 'clustername', GangliaAcl::VIEW ) );
      $this->assertTrue( $this->object->isAllowed( 'newuser', 'clustername', GangliaAcl::EDIT ) );
    }
    
    public function testGuestCanViewViews() {
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::GUEST, GangliaAcl::ALL_VIEWS, GangliaAcl::VIEW ) );
    }
    
    public function testAdminCanViewViews() {
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::ADMIN, GangliaAcl::ALL_VIEWS, GangliaAcl::VIEW ) );
    }
    
    public function testGuestCannotEditViews() {
      $this->assertFalse( $this->object->isAllowed( GangliaAcl::GUEST, GangliaAcl::ALL_VIEWS, GangliaAcl::EDIT ) );
    }
    
    public function testAdminCanEditViews() {
      $this->assertTrue( $this->object->isAllowed( GangliaAcl::ADMIN, GangliaAcl::ALL_VIEWS, GangliaAcl::EDIT ) );
    }
    
    public function testUserCanViewViews() {
      $this->object->addRole( 'newuser', GangliaAcl::GUEST );
      $this->assertTrue( $this->object->isAllowed( 'newuser', GangliaAcl::ALL_VIEWS, GangliaAcl::VIEW ) );
    }
    
    public function testUserCannotEditViews() {
      $this->object->addRole( 'newuser', GangliaAcl::GUEST );
      $this->assertFalse( $this->object->isAllowed( 'newuser', GangliaAcl::ALL_VIEWS, GangliaAcl::EDIT ) );
    }
    
}
?>
