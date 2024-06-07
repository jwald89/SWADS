<script setup>
import { Link } from "@inertiajs/vue3";
import { defineComponent } from "vue";

defineComponent({
    Link,
});
</script>

<template>
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <Link class="nav-link" href="/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD</span>
                </Link>
            </li>
            <!-- End Dashboard Nav -->

            <li class="nav-heading">Modules</li>

            <li class="nav-item">
                <a
                    class="nav-link collapsed"
                    data-bs-target="#components-nav"
                    data-bs-toggle="collapse"
                    href="#"
                >
                    <i class="bi bi-menu-button-wide"></i><span>AICS</span
                    ><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul
                    id="components-nav"
                    class="nav-content collapse"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <Link
                            :class="{ 'bg-primary': $page.url == '/intake' }"
                            href="/intake"
                        >
                            <i class="bi bi-circle"></i><span>INTAKE</span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            :class="{
                                'bg-primary': $page.url == '/monitoring',
                            }"
                            href="/monitoring"
                        >
                            <i class="bi bi-circle"></i><span>MONITORING</span>
                        </Link>
                    </li>
                </ul>
            </li>
            <!-- End Components Nav -->

            <li class="nav-item">
                <Link class="nav-link" href="/sectoral-data">
                    <i class="bi bi-journal-text"></i><span>SECTORAL DATA</span>
                </Link>
            </li>
            <!-- End Forms Nav -->

            <!-- <li class="nav-item">
                <Link href="/profile" class="nav-link collapsed">
                    <i class="bi bi-layout-text-window-reverse"></i
                    ><span>CERTIFICATE OF ELIGIBILITY</span
                    ><i class="bi ms-auto"></i>
                </Link>
            </li> -->
            <!-- End Tables Nav -->

            <!-- <li class="nav-item">
                <a
                    class="nav-link collapsed"
                    data-bs-target="#charts-nav"
                    data-bs-toggle="collapse"
                    href="#"
                >
                    <i class="bi bi-bar-chart"></i><span>CHARTS</span
                    ><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul
                    id="charts-nav"
                    class="nav-content collapse"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <a href="charts-chartjs.html">
                            <i class="bi bi-circle"></i><span>Chart.js</span>
                        </a>
                    </li>
                </ul>
            </li> -->
            <!-- End Charts Nav -->

            <!-- <li class="nav-item">
                <a
                    class="nav-link collapsed"
                    data-bs-target="#icons-nav"
                    data-bs-toggle="collapse"
                    href="#"
                >
                    <i class="bi bi-person"></i><span>PROFILE</span
                    ><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul
                    id="icons-nav"
                    class="nav-content collapse"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <a href="icons-bootstrap.html">
                            <i class="bi bi-circle"></i
                            ><span>Bootstrap Icons</span>
                        </a>
                    </li>
                </ul>
            </li> -->
            <!-- End Icons Nav -->

            <li class="nav-heading">Maintenance</li>

            <li class="nav-item">
                <Link
                    class="nav-link collapsed"
                    :class="{ 'bg-primary': $page.url == '/profile' }"
                    href="/profile"
                >
                    <i class="bi bi-person"></i>
                    <span>Users</span>
                </Link>
            </li>
            <!-- End Profile Page Nav -->

            <li class="nav-item">
                <Link class="nav-link collapsed" href="register">
                    <i class="bi bi-card-list"></i>
                    <span>Types of Assistance</span>
                </Link>
            </li>
            <!-- End Register Page Nav -->

            <li class="nav-item">
                <Link class="nav-link collapsed" href="register">
                    <i class="bi bi-card-list"></i>
                    <span>Municipality</span>
                </Link>
            </li>

            <!-- End Register Page Nav -->

            <li class="nav-item">
                <Link class="nav-link collapsed" href="register">
                    <i class="bi bi-card-list"></i>
                    <span>Barangay</span>
                </Link>
            </li>
            <!-- End Register Page Nav -->

            <li class="nav-item">
                <Link class="nav-link collapsed" href="register">
                    <i class="bi bi-card-list"></i>
                    <span>Sector</span>
                </Link>
            </li>
            <!-- End Register Page Nav -->

            <li class="nav-item">
                <Link class="nav-link collapsed" href="register">
                    <i class="bi bi-card-list"></i>
                    <span>Staff Administered</span>
                </Link>
            </li>
            <!-- End Register Page Nav -->

            <li class="nav-item">
                <Link class="nav-link collapsed" href="register">
                    <i class="bi bi-card-list"></i>
                    <span>Liaison</span>
                </Link>
            </li>
            <!-- End Register Page Nav -->

            <li class="nav-item">
                <Link class="nav-link collapsed" href="register">
                    <i class="bi bi-card-list"></i>
                    <span>Office Charges</span>
                </Link>
            </li>
            <!-- End Register Page Nav -->

            <li class="nav-heading">Reports</li>
        </ul>
    </aside>
    <!-- End Sidebar-->
</template>
