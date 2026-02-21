document.addEventListener("DOMContentLoaded", () => main());

function main() {
  const deleteBtn = document.querySelector(".btn.delete");

  if (!deleteBtn) return;

  deleteBtn.addEventListener("click", (e) => {
    e.preventDefault();

    if (confirm("このメモを本当に削除しますか？")) {
      deleteBtn.form.requestSubmit(deleteBtn);
    }
  });
}
