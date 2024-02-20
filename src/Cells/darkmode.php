<?php if (!$header) : ?>
    <!--:Dark Mode:-->
    <div class="position-absolute z-3 w-auto h-auto end-0 top-0 mt-4 me-4">
        <div class="dropdown">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="bs-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
                <span class="theme-icon-active d-flex align-items-center">
                    <span class="material-symbols-rounded align-middle"></span>
                </span>
            </a>
            <!--:Dark Mode Options:-->
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bs-theme" style="--bs-dropdown-min-width: 9rem;">
                <li class="mb-1">
                    <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light">
                        <span class="theme-icon d-flex align-items-center">
                            <span class="material-symbols-rounded align-middle me-2">
                                lightbulb
                            </span>
                        </span>
                        Light
                    </button>
                </li>
                <li class="mb-1">
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
                        <span class="theme-icon d-flex align-items-center">
                            <span class="material-symbols-rounded align-middle me-2">
                                dark_mode
                            </span>
                        </span>
                        Dark
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto">
                        <span class="theme-icon d-flex align-items-center">
                            <span class="material-symbols-rounded align-middle me-2">
                                invert_colors
                            </span>
                        </span>
                        Auto
                    </button>
                </li>
            </ul>
        </div>
    </div>
<?php endif ?>