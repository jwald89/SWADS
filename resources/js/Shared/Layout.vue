<script setup>
import { defineComponent, onMounted, ref } from "vue";
import Dashboard from "../Pages/Dashboard.vue";
import { Link, usePage } from "@inertiajs/vue3";
import axios from "axios";

function greet(event) {
    alert(`Hello ${name.value}!`);
    // `event` is the native DOM event
    if (event) {
        alert(event.target.tagName);
    }
}

const page = usePage();
const currentRoute = ref("");

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};

const logout = () => {
    try {
        axios.post(`/logout`).then((response) => {
            window.location.href = "/login-page";
        });
    } catch (error) {
        errorMessage.value = "An error occurred during logout.";
        console.error("Error during logout:", error);
    }
};

onMounted(() => {
    currentRoute.value = location.pathname;
});

defineComponent({
    Dashboard,
    Link,
});
</script>

<template>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <Link href="" class="logo d-flex align-items-center">
                <div class="mt-4">
                    <img
                        src="/public/assets/img/pdms-logo.png"
                        style="max-height: 110px"
                    />
                </div>
            </Link>
            <i @click="greet" class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <div class="search-bar">
            <form
                class="search-form d-flex align-items-center"
                method="POST"
                action="#"
            >
                <input
                    type="text"
                    name="query"
                    placeholder="Search"
                    title="Enter search keyword"
                />
                <button type="submit" title="Search">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>
                <!-- End Search Icon-->

                <li class="nav-item dropdown">
                    <a
                        class="nav-link nav-icon"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span> </a
                    ><!-- End Notification Icon -->

                    <ul
                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                    >
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"
                                ><span
                                    class="badge rounded-pill bg-primary p-2 ms-2"
                                    >View all</span
                                ></a
                            >
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="notification-item">
                            <i
                                class="bi bi-exclamation-circle text-warning"
                            ></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>
                    </ul>
                    <!-- End Notification Dropdown Items -->
                </li>
                <!-- End Notification Nav -->

                <li class="nav-item dropdown">
                    <a
                        class="nav-link nav-icon"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span> </a
                    ><!-- End Messages Icon -->

                    <ul
                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages"
                    >
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"
                                ><span
                                    class="badge rounded-pill bg-primary p-2 ms-2"
                                    >View all</span
                                ></a
                            >
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <!-- <img
                                    src="assets/img/messages-1.jpg"
                                    alt=""
                                    class="rounded-circle"
                                /> -->
                                <div>
                                    <h4>Maria Hudson</h4>
                                    <p>
                                        Velit asperiores et ducimus soluta
                                        repudiandae labore officia est ut...
                                    </p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <!-- <img
                                    src="assets/img/messages-2.jpg"
                                    alt=""
                                    class="rounded-circle"
                                /> -->
                                <div>
                                    <h4>Anna Nelson</h4>
                                    <p>
                                        Velit asperiores et ducimus soluta
                                        repudiandae labore officia est ut...
                                    </p>
                                    <p>6 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <!-- <img
                                    src="assets/img/messages-3.jpg"
                                    alt=""
                                    class="rounded-circle"
                                /> -->
                                <div>
                                    <h4>David Muldon</h4>
                                    <p>
                                        Velit asperiores et ducimus soluta
                                        repudiandae labore officia est ut...
                                    </p>
                                    <p>8 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>
                    </ul>
                    <!-- End Messages Dropdown Items -->
                </li>
                <!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">
                    <a
                        class="nav-link nav-profile d-flex align-items-center pe-0"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <!-- <img
                            src="assets/img/profile-img.jpg"
                            alt="Profile"
                            class="rounded-circle"
                        /> -->
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{
                            page.props.role_type
                        }}</span> </a
                    ><!-- End Profile Iamge Icon -->

                    <ul
                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                    >
                        <li class="dropdown-header">
                            <h6 class="text-uppercase">
                                {{ page.props.fullname }}
                            </h6>
                            <span>{{ page.props.role_type }}</span>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li>
                            <button
                                @click="logout"
                                class="dropdown-item d-flex align-items-center"
                            >
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Log Out</span>
                            </button>
                        </li>
                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->
            </ul>
        </nav>
        <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item" v-if="hasAccess(['admin'])">
                <Link class="nav-link" href="/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD</span>
                </Link>
            </li>
            <li class="nav-item" v-if="hasAccess(['user'])">
                <Link class="nav-link" href="/user/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD USER</span>
                </Link>
            </li>
            <li class="nav-item" v-if="hasAccess(['liaison'])">
                <Link class="nav-link" href="/liaison/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD LIAISON</span>
                </Link>
            </li>
            <li class="nav-item" v-if="hasAccess(['municipal'])">
                <Link class="nav-link" href="/municipal/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD MUNICIPAL</span>
                </Link>
            </li>
            <!-- End Dashboard Nav -->

            <li class="nav-heading">Modules</li>

            <li class="nav-item" v-if="hasAccess(['admin', 'user'])">
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
                    :class="{
                        show:
                            currentRoute.includes('intake') ||
                            currentRoute.includes('monitoring'),
                    }"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <Link href="/intake">
                            <i class="bi bi-circle"></i
                            ><span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('intake'),
                                }"
                                >INTAKE</span
                            >
                        </Link>
                    </li>
                    <li>
                        <Link href="/monitoring">
                            <i class="bi bi-circle"></i
                            ><span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('monitoring'),
                                }"
                                >MONITORING</span
                            >
                        </Link>
                    </li>
                </ul>
            </li>
            <!-- End Components Nav -->

            <!-- LIAISON -->
            <li class="nav-item" v-if="hasAccess(['liaison'])">
                <Link class="nav-link" href="/monitoring">
                    <i class="bi bi-menu-button-wide"></i
                    ><span
                        :class="{
                            'text-primary': currentRoute.includes('monitoring'),
                        }"
                        >MONITORING</span
                    >
                </Link>
            </li>

            <li
                class="nav-item"
                v-if="hasAccess(['admin', 'user', 'municipal'])"
            >
                <Link class="nav-link" href="/sectoral-data">
                    <i class="bi bi-journal-text"></i><span>SECTORAL DATA</span>
                </Link>
            </li>

            <!-- End Forms Nav -->
            <div v-if="hasAccess(['admin'])">
                <li class="nav-heading">Maintenance</li>
                <li class="nav-item">
                    <Link
                        class="nav-link collapsed"
                        href="/user-registration/index"
                    >
                        <i class="bi bi-person"></i>
                        <span
                            :class="{
                                'text-primary': currentRoute.includes(
                                    'user-registration/index'
                                ),
                            }"
                            >Users</span
                        >
                    </Link>
                </li>
                <!-- End Profile Page Nav -->
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="/type-assistance">
                        <i class="bi bi-card-list"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('type-assistance'),
                            }"
                            >Types of Assistance</span
                        >
                    </Link>
                </li>
                <!-- End Register Page Nav -->
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="/municipality">
                        <i class="bi bi-card-list"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('municipality'),
                            }"
                            >Municipality</span
                        >
                    </Link>
                </li>
                <!-- End Register Page Nav -->
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="/barangay">
                        <i class="bi bi-card-list"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('barangay'),
                            }"
                            >Barangay</span
                        >
                    </Link>
                </li>
                <!-- End Register Page Nav -->
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="/sectors">
                        <i class="bi bi-card-list"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('sectors'),
                            }"
                            >Sector</span
                        >
                    </Link>
                </li>
                <!-- End Register Page Nav -->
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="/staff-admin">
                        <i class="bi bi-card-list"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('staff-admin'),
                            }"
                            >Staff Administered</span
                        >
                    </Link>
                </li>
                <!-- End Register Page Nav -->
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="/liaison">
                        <i class="bi bi-card-list"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('liaison'),
                            }"
                            >Liaison</span
                        >
                    </Link>
                </li>
                <!-- End Register Page Nav -->
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="/office-charges">
                        <i class="bi bi-card-list"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('office-charges'),
                            }"
                            >Office Charges</span
                        >
                    </Link>
                </li>
            </div>
            <!-- End Register Page Nav -->
            <div>
                <li class="nav-heading">Reports</li>
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="#">
                        <i class="bi bi-card-list"></i>
                        <span>Intake Sheets & COE Served</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="#">
                        <i class="bi bi-card-list"></i>
                        <span>AICS Per Municipality</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="#">
                        <i class="bi bi-card-list"></i>
                        <span>AICS Served Per Sectoral Group</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link collapsed" href="#">
                        <i class="bi bi-card-list"></i>
                        <span>AICS Per Sectoral Group</span>
                    </Link>
                </li>
            </div>
        </ul>
    </aside>
    <!-- End Sidebar-->

    <main class="main" id="main">
        <slot />
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright
            <strong><span>Province of Surigao Del Sur</span></strong
            >. All Rights Reserved
        </div>
        <div class="credits">Developed by <a href="">PADMO-ITU</a></div>
    </footer>
    <!-- End Footer -->

    <a
        href="#"
        class="back-to-top d-flex align-items-center justify-content-center"
    >
        <i class="bi bi-arrow-up-short"></i>
    </a>
</template>
