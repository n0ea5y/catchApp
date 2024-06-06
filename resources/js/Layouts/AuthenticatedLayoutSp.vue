<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const openMenu = ref(false);

const handleMenuOpen = () => {
  openMenu.value = !openMenu.value;
};
</script>

<template>
    <header id="header" class="flex justify-between py-3 px-4 bg-[#f5fffa] shadow">
        <h1>ロゴ</h1>
        
        <!-- ハンバーガーメニューボタン -->
        <button
          @click="handleMenuOpen"
          type="button"
          class="z-10 space-y-2"
        >
          <div
            :class="openMenu 
              ? 'w-8 h-0.5 bg-gray-600 translate-y-2.5 rotate-45 transition duration-500 ease-in-out' 
              : 'w-8 h-0.5 bg-gray-600 transition duration-500 ease-in-out'"
          />
          <div
            :class="openMenu 
              ? 'opacity-0 transition duration-500 ease-in-out' 
              : 'w-8 h-0.5 bg-gray-600 transition duration-500 ease-in-out'"
          />
          <div
            :class="openMenu 
              ? 'w-8 h-0.5 bg-gray-600 -rotate-45 transition duration-500 ease-in-out' 
              : 'w-8 h-0.5 bg-gray-600 transition duration-500 ease-in-out'"
          />
        </button>

        <!-- ナビゲーションメニュー -->
        <nav
          :class="openMenu 
            ? 'text-left fixed bg-black/75 right-0 top-0 w-[100%] h-screen flex flex-col justify-start pt-8 px-3 ease-linear duration-300' 
            : 'fixed right-[-100%] ease-linear duration-300'"
        >
          <ul class="mt-6 flex flex-col items-center text-white font-black">
            <li>
              <ResponsiveNavLink class="text-white font-black" :href="route('sp.dashboard')" :active="route().current('dashboard')">
                  Dashboard
              </ResponsiveNavLink>
            </li>
            <li>
              <ResponsiveNavLink class="text-white font-black" :href="route('sp.user.index')">
                  ユーザーリスト
              </ResponsiveNavLink>
            </li>
          </ul>
        </nav>
      </header>
  <main class="flex-grow">
    <slot />
  </main>

  <footer id="footer" class="bg-[#f5fffa] fixed bottom-0 w-full">
    <div class="mx-auto text-gray-400 py-6 px-4 sm:px-6 text-center">
      © 2021 - Catch App.
    </div>
  </footer>
</template>
<style scoped>

</style>