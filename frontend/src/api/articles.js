const API_URL = "/api"


export async function getArticles() {
    const res = await fetch(`${API_URL}/articles`)
    if (!res.ok) throw new Error("Ошибка загрузки статей")
    return res.json()
}

export async function getArticle(id) {
    const res = await fetch(`${API_URL}/articles/${id}`)
    if (!res.ok) throw new Error("Ошибка загрузки статьи")
    return res.json()
}

export async function createArticle(data) {
    const res = await fetch(`${API_URL}/articles`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
    })
    if (!res.ok) throw new Error("Ошибка создания статьи")
    return res.json()
}

export async function updateArticle(id, data) {
    const res = await fetch(`${API_URL}/articles/${id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
    })
    if (!res.ok) throw new Error("Ошибка обновления статьи")
    return res.json()
}

export async function deleteArticle(id) {
    const res = await fetch(`${API_URL}/articles/${id}`, { method: "DELETE" })
    if (!res.ok) throw new Error("Ошибка удаления статьи")
    return true
}


export async function createComment(articleId, data) {
    const res = await fetch(`${API_URL}/articles/${articleId}/comments`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
    })
    if (!res.ok) throw new Error("Ошибка добавления комментария")
    return res.json()
}

export async function deleteComment(commentId) {
    const res = await fetch(`${API_URL}/comments/${commentId}`, { method: "DELETE" })
    if (!res.ok) throw new Error("Ошибка удаления комментария")
    return true
}
