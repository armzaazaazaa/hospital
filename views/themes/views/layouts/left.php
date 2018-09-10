<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->

        <!-- search form -->

        <!-- /.search form -->
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree' , 'data-widget'=> 'tree'],
                'items' => [
                    [ 'class'=>'fa fa-fw fa-amazon', 'label' => 'Home', 'url' => ['/teleecho']],



                ],
            ]
        ) ?>

        <ul class="sidebar-menu" data-widget="tree">

            <!-- Optionally, you can add icons to the links -->
<!--            <li><a href="/hospital/index.php/teleecho"><i class="fa fa-link"></i> <span>Another Link</span></a></li>-->
            <li class="treeview">
                <a href="#"><i class="fa fa-fw  fa-ambulance"></i> <span>จัดการข้อมูล</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/hospital/index.php/teleecho/symptom">เพิ่มผลวินิฉัย</a></li>
                    <li><a href="/hospital/index.php/teleecho/showresults">กล่องจดหมาย</a></li>
                    <li><a href="/hospital/index.php/teleecho/patient">จัดการคนไข้</a></li>


                </ul>
            </li>
        </ul>

    </section>

</aside>
