<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { onMounted, onUnmounted } from 'vue';

const handleMenuOpen = () => {
  const menuButton = document.getElementById('menu-button');
  const mask = document.getElementById('mask');
  const navMenu = document.getElementById('nav-menu');
  menuButton.classList.toggle('open');
  mask.classList.toggle('open');
  navMenu.classList.toggle('open');
};
// 初期ロード時とリサイズ時にビューポートの高さを設定
onMounted(() => {
  setViewportHeight();
  window.addEventListener('resize', setViewportHeight);
});

onUnmounted(() => {
  window.removeEventListener('resize', setViewportHeight);
});

const setViewportHeight = () => {
  const vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', `${vh}px`);
};
</script>

<template>
    <header id="header" class="flex justify-between py-3 px-4 bg-[#f5fffa] shadow">
        <h1>ロゴ</h1>
        <div class="menu" id="menu-button" @click="handleMenuOpen">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="mask" id="mask" @click="handleMenuOpen"></div>
      <nav class="nav-menu" id="nav-menu">
        <ul>
          <li>
            <ResponsiveNavLink class="text-white" :href="route('sp.dashboard')" :active="route().current('dashboard')">
                Dashboard
            </ResponsiveNavLink>
          </li>
          <li>
            <ResponsiveNavLink class="text-white" :href="route('sp.sale.index')">
                売上登録
            </ResponsiveNavLink>
          </li>
        </ul>
      </nav>
      </header>
  <main class="flex-grow">
    <slot />
  </main>

  <footer id="footer" class="bg-[#f5fffa] fixed bottom-0 w-full">
    <div class="mx-auto text-gray-400 py-2 px-4 sm:px-6 text-center">
      © 2021 - Catch App.
    </div>
  </footer>
</template>
<style scoped>
:root {
  --vh: 1vh; /* 初期値を設定 */
}
.menu {
  position: relative;
  height: 30px;
  width: 30px;
  cursor: pointer; /* クリック可能なカーソルを表示 */
}

.menu span {
  position: absolute;
  height: 2px;
  width: 100%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: black;
  border-radius: 1px;
  transition: 0.3s; /* アニメーションの追加 */
}

.menu span:nth-of-type(1) {
  top: calc(50% - 10px);
}

.menu span:nth-of-type(2) {
  /* 中央のバー */
}

.menu span:nth-of-type(3) {
  top: calc(50% + 10px);
}

.menu.open span:nth-of-type(1) {
  top: 50%;
  transform: translate(-50%, -50%) rotate(45deg); /* バッテンマークの上部分 */
}

.menu.open span:nth-of-type(2) {
  opacity: 0; /* 中央のバーを非表示 */
}

.menu.open span:nth-of-type(3) {
  top: 50%;
  transform: translate(-50%, -50%) rotate(-45deg); /* バッテンマークの下部分 */
}

.mask {
  opacity: 0;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8); /* 半透明の黒 */
  transform: translate(100%, 0);
  z-index: 100; /* メニューの上に表示 */
  transition: 0.5s;
}

.mask.open {
  opacity: 1;
  transform: translate(0, 0);
}

.nav-menu {
  opacity: 1;
  position: fixed;
  top: 50%;
  left: 100%;
  transform: translate(100%, -50%);
  z-index: 110;
  transition: 0.5s;
}
.nav-menu.open {
  opacity: 1;
  left: 50%;
  transform: translate(-50%, -50%);

}

.nav-menu ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav-menu li {
  margin-bottom: 20px;
}

</style>