
// 金額3桁区切り
export function formatSale(num) {
    return Number(num).toLocaleString();
}

// 日付の整形（OO年OO月OO日）
export function formatDate(date) {
    const formattedDate = new Date(date);
    const year = formattedDate.getFullYear();
    const month = String(formattedDate.getMonth() + 1).padStart(2, '0');
    const day = String(formattedDate.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}
