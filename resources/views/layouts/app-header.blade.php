<header
    class="sticky top-0 z-50 flex w-full border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900"
    x-data="{
        isApplicationMenuOpen: false,

        toggleApplicationMenu() {
            this.isApplicationMenuOpen = !this.isApplicationMenuOpen;
        }
    }"
>
    <div class="flex flex-col justify-between flex-1 xl:flex-row xl:px-6">

        <!-- TOP BAR -->
        <div
            class="flex items-center justify-between w-full gap-2 px-4 py-3 border-b border-gray-200 dark:border-gray-800 xl:border-b-0 xl:px-0 lg:py-4">

            <div class="flex items-center gap-3">

                <!-- DESKTOP SIDEBAR TOGGLE -->
                <button
                    type="button"
                    class="hidden xl:flex items-center justify-center w-11 h-11 rounded-lg border border-gray-200 text-gray-500 dark:border-gray-800 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 transition"
                    @click="$store.sidebar.toggleExpanded()"
                >

                    <!-- COLLAPSED ICON -->
                    <svg
                        x-show="!$store.sidebar.isExpanded"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M4 6H20M4 12H14M4 18H20"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>

                    <!-- EXPANDED ICON -->
                    <svg
                        x-show="$store.sidebar.isExpanded"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M6 6L18 18M6 18L18 6"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>

                </button>

                <!-- MOBILE SIDEBAR TOGGLE -->
                <button
                    type="button"
                    class="flex xl:hidden items-center justify-center w-10 h-10 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 transition"
                    @click="$store.sidebar.toggleMobileOpen()"
                >

                    <!-- HAMBURGER -->
                    <svg
                        x-show="!$store.sidebar.isMobileOpen"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M4 6H20M4 12H20M4 18H20"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>

                    <!-- CLOSE -->
                    <svg
                        x-show="$store.sidebar.isMobileOpen"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M6 6L18 18M6 18L18 6"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>

                </button>

                <!-- MOBILE LOGO -->
                <a href="/" class="xl:hidden">
                    <div
                        class="w-10 h-10 rounded-lg bg-brand-500 flex items-center justify-center text-white font-bold">
                        K
                    </div>
                </a>

                <!-- SEARCH -->
                <div class="hidden xl:block">
                    <form>
                        <div class="relative">

                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">

                                <svg
                                    class="fill-gray-500 dark:fill-gray-400"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                                        fill=""
                                    />
                                </svg>

                            </span>

                            <input
                                type="text"
                                placeholder="Search or type command..."
                                class="h-11 xl:w-[430px] rounded-lg border border-gray-200 bg-transparent py-2.5 pl-12 pr-14 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 dark:border-gray-800 dark:bg-white/[0.03] dark:text-white"
                            />

                            <button
                                type="button"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-xs text-gray-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400"
                            >
                                <span>⌘</span>
                                <span>K</span>
                            </button>

                        </div>
                    </form>
                </div>

            </div>

            <!-- RIGHT ACTION -->
            <div class="flex items-center gap-3">

                <!-- MOBILE MORE -->
                <button
                    @click="toggleApplicationMenu()"
                    class="flex xl:hidden items-center justify-center w-10 h-10 rounded-lg text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5"
                >
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M5.99902 10.4951C6.82745 10.4951 7.49902 11.1667 7.49902 11.9951V12.0051C7.49902 12.8335 6.82745 13.5051 5.99902 13.5051C5.1706 13.5051 4.49902 12.8335 4.49902 12.0051V11.9951C4.49902 11.1667 5.1706 10.4951 5.99902 10.4951ZM17.999 10.4951C18.8275 10.4951 19.499 11.1667 19.499 11.9951V12.0051C19.499 12.8335 18.8275 13.5051 17.999 13.5051C17.1706 13.5051 16.499 12.8335 16.499 12.0051V11.9951C16.499 11.1667 17.1706 10.4951 17.999 10.4951ZM13.499 11.9951C13.499 11.1667 12.8275 10.4951 11.999 10.4951C11.1706 10.4951 10.499 11.1667 10.499 11.9951V12.0051C10.499 12.8335 11.1706 13.5051 11.999 13.5051C12.8275 13.5051 13.499 12.8335 13.499 12.0051V11.9951Z"
                            fill="currentColor"
                        />
                    </svg>
                </button>

                <!-- NOTIFICATION -->
                <x-header.notification-dropdown />

                <!-- USER -->
                <x-header.user-dropdown />

            </div>
        </div>

        <!-- MOBILE MENU -->
        <div
            x-show="isApplicationMenuOpen"
            x-transition
            class="flex xl:hidden items-center justify-between gap-4 px-5 py-4 border-t border-gray-200 dark:border-gray-800"
        >
            <div class="flex items-center gap-3">
                <x-header.notification-dropdown />
            </div>
        </div>

    </div>
</header>