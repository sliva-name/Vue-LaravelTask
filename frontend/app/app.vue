<template>
  <div class="container">
    <h1>Статьи</h1>
      <!-- Состояние загрузки -->
      <div v-if="status === 'pending'" class="loading">
        Загрузка статей...
      </div>

      <!-- Состояние ошибки -->
      <div v-else-if="error" class="error">
        <h3>Ошибка загрузки</h3>
        <p>{{ error.message || 'Произошла ошибка при загрузке статей' }}</p>
        <button @click="refresh()" class="retry-btn">Повторить</button>
      </div>
      
      <!-- Состояние успешной загрузки -->
      <div v-else-if="data && data.length > 0" class="articles">
        <div v-for="article in data" :key="article.id" class="article">
          <h2>{{ article.title }}</h2>
          <p class="author">Автор: {{ article.author }}</p>
          <p class="content">{{ article.content }}</p>
          <p class="date">{{ formatDate(article.created_at) }}</p>
        </div>
      </div>

      <!-- Состояние пустого результата -->
      <div v-else class="empty">
        <p>Статьи не найдены</p>
      </div>
  </div>
</template>

<script setup>
const nuxtApp = useNuxtApp()
const api = nuxtApp.$api

// можно проверить
if (!api) {
  console.error('Плагин $api не найден в useNuxtApp() — перезапусти dev сервер и проверь путь plugins/api.ts')
}

// использовать
const data = await api.fetch('/articles') // server -> http://laravel_app:9000/api/articles, client -> /api/articles

// format date helper
const formatDate = (dateString) => {
  if (!dateString) return ''
  return new Date(dateString).toLocaleDateString('ru-RU', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>
  
<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

h1 {
  color: #333;
  text-align: center;
  margin-bottom: 30px;
  font-size: 2.5rem;
  font-weight: 600;
}

.loading {
  text-align: center;
  font-size: 18px;
  color: #666;
  padding: 40px;
  background: #f8f9fa;
  border-radius: 8px;
  border: 2px dashed #dee2e6;
}

.error {
  text-align: center;
  padding: 20px;
  background: #f8d7da;
  border: 1px solid #f5c6cb;
  border-radius: 8px;
  color: #721c24;
}

.error h3 {
  margin: 0 0 10px 0;
  color: #721c24;
}

.retry-btn {
  background: #dc3545;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
  transition: background-color 0.2s;
}

.retry-btn:hover {
  background: #c82333;
}

.empty {
  text-align: center;
  padding: 40px;
  color: #6c757d;
  font-size: 18px;
  background: #f8f9fa;
  border-radius: 8px;
}

.articles {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.article {
  border: 1px solid #e9ecef;
  border-radius: 12px;
  padding: 24px;
  background: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
}

.article:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.article h2 {
  color: #2c3e50;
  margin-bottom: 12px;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.3;
}

.author {
  color: #6c757d;
  font-style: italic;
  margin-bottom: 12px;
  font-size: 0.9rem;
  font-weight: 500;
}

.content {
  line-height: 1.7;
  margin-bottom: 16px;
  color: #495057;
  text-align: justify;
}

.date {
  color: #6c757d;
  font-size: 0.85rem;
  font-weight: 500;
  border-top: 1px solid #e9ecef;
  padding-top: 12px;
  margin-top: 12px;
}
</style>