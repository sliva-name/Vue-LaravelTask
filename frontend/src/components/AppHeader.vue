<template>
  <header class="bg-gray-900">
    <nav
        aria-label="Global"
        class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8"
    >
      <div class="flex lg:flex-1">
        <router-link to="/" class="-m-1.5 p-1.5 flex items-center">
          <span class="sr-only">Articles App</span>
          <img
              src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
              alt="Logo"
              class="h-8 w-auto"
          />
        </router-link>
      </div>

      <!-- Десктоп меню -->
      <div class="hidden lg:flex lg:gap-x-12">
        <router-link
            to="/"
            class="text-lg font-semibold text-white hover:text-indigo-400 transition"
        >
          Главная
        </router-link>
        <router-link
            to="/articles/new"
            class="text-lg font-semibold text-white hover:text-indigo-400 transition"
        >
          Создать статью
        </router-link>
      </div>
    </nav>
  </header>
</template>


