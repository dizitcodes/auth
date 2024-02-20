<?php if ($notificationsView) : ?>
    <li class="nav-item dropdown d-flex align-items-center justify-content-center flex-column h-100 mx-1 mx-md-3">
        <a href="#" class="nav-link p-0 position-relative size-40 d-flex align-items-center justify-content-center" aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <span class="material-symbols-rounded">
                notifications
            </span>
            <span class="size-5 rounded-circle d-flex align-items-center justify-content-center position-absolute end-0 top-0 mt-2 me-1 bg-danger small"></span>
        </a>


        <div class="dropdown-menu mt-0 p-0 overflow-hidden dropdown-menu-end dropdown-menu-sm">
            <!--notification header-->
            <div class="py-3 px-4 bg-primary text-white d-flex align-items-center">
                <h5 class="me-3 mb-0 flex-grow-1">Notificações</h5>
                <div class="flex-shrink-0">
                    <?php //<a href="#!" class="btn btn-white btn-sm">View All</a> 
                    ?>
                </div>
            </div>
            <div style="height:290px" data-simplebar>
                <div class="list-group list-group-flush mb-0">
                    <?php foreach ($notifications ?? [] as $notification) : ?>
                        <!--//Notification item start//-->
                        <a href="#" class="list-group-item list-group-item-action py-3 px-4 d-flex align-items-center">
                            <span class="d-block me-3">
                                <span class="d-flex align-items-center justify-content-center lh-1 size-50 bg-danger-subtle text-danger rounded-circle">
                                    <span class="material-symbols-rounded">
                                        percent
                                    </span>
                                </span>
                            </span>

                            <div class="flex-grow-1 flex-wrap pe-3">
                                <span class="mb-0 d-block"><strong>Pro discount</strong> Upgrade
                                    to pro plan with 30%
                                    discount, Apply coupon <span class="badge bg-primary">PRO30</span></span>
                                <small class="text-body-secondary">2h Ago</small>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </li>
<?php endif ?>