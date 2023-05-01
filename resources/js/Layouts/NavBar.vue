<template>
    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>

    <nav
        class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top"
    >
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div
                        class="mr-auto float-left bookmark-wrapper d-flex align-items-center"
                    >
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto">
                                <a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs"
                                    href="#"
                                    ><i class="ficon bx bx-menu"></i
                                ></a>
                            </li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a
                                class="dropdown-toggle nav-link dropdown-user-link"
                                href="#"
                                data-toggle="dropdown"
                            >
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name">
                                        {{ $page.props.auth.user.name }}</span
                                    >
                                    <!-- <span class="user-status text-muted"
                                        >Available</span
                                    > -->
                                </div>
                                <span
                                    v-if="
                                        $page.props.jetstream
                                            .managesProfilePhotos
                                    "
                                >
                                    <img
                                        class="round"
                                        :src="
                                            $page.props.auth.user
                                                .profile_photo_url
                                        "
                                        :alt="$page.props.auth.user.name"
                                        height="40"
                                        width="40"
                                    />
                                </span>
                                <span v-else>
                                    <img
                                        class="round"
                                        src="../../../public/app-assets/images/portrait/small/avatar-s-11.jpg"
                                        alt="avatar"
                                        height="40"
                                        width="40"
                                    />
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0">
                                <Link
                                    class="dropdown-item"
                                    :href="route('profile.show')"
                                    ><i class="bx bx-user mr-50"></i> Edit
                                    Profile</Link
                                >
                                <div class="dropdown-divider mb-0"></div>
                                <a
                                    @click.prevent="logout"
                                    class="dropdown-item"
                                    style="cursor: pointer"
                                    ><i class="bx bx-power-off mr-50"></i>
                                    Logout</a
                                >
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->
</template>

<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
const logout = () => {
    router.post(route("logout"));
};
</script>
