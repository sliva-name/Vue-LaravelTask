<template>
  <div>
    <ul v-if="localComments.length" class="space-y-3">
      <li v-for="comment in localComments" :key="comment.id" class="bg-gray-800 p-4 rounded">
        <p>{{ comment.text }}</p>
        <p class="text-gray-400 text-sm mt-1">Автор: {{ comment.author }}</p>
      </li>
    </ul>
    <p v-else class="text-gray-500">Комментариев пока нет.</p>

    <div class="mt-6">
      <CommentForm :loading="loading" @submit="submitComment"/>
    </div>
  </div>
</template>

<script setup>
import {ref, reactive, watch} from "vue"
import {createComment} from "../api/articles.js"
import CommentForm from "./CommentForm.vue"

const props = defineProps({
  articleId: {type: Number, required: true},
  comments: {type: Array, default: () => []}
})

const emit = defineEmits(["comment-added"])
const loading = ref(false)

// создаём локальный реактивный массив комментариев
const localComments = reactive([...props.comments])

// если props.comments изменится извне, обновим localComments
watch(
    () => props.comments,
    (newVal) => {
      localComments.splice(0, localComments.length, ...newVal)
    }
)

async function submitComment(newComment) {
  if (!newComment.text.trim()) return
  loading.value = true
  try {
    const comment = await createComment(props.articleId, newComment)
    localComments.push(comment)
    emit("comment-added", comment)
  } catch (e) {
    console.error("Ошибка при добавлении комментария:", e)
    alert("Не удалось добавить комментарий")
  } finally {
    loading.value = false
  }
}
</script>
