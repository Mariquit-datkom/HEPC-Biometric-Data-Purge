const today = new Date();
today.setHours(0, 0, 0, 0);

const dashboardContent = document.querySelector('.dashboard-content');
const items = Array.from(dashboardContent.querySelectorAll('.dashboard-item'));

items.forEach(item => {
    const cutoffText = item.querySelector('.log-cutoff').innerText.replace('Cutoff: ', '').trim();
    const cutoffDate = new Date(cutoffText);

    const compareDate = new Date(cutoffDate);
    compareDate.setHours(0, 0, 0, 0);

    const diffInTime = today.getTime() - compareDate.getTime();    
    const diffInDays = diffInTime / (1000 * 3600 * 24);

    item.classList.remove('due', 'overdue', 'critical');

    if (diffInDays === 0) item.classList.add('due');
    else if (diffInDays > 0) {
        item.classList.add('overdue');
        if (diffInDays > 7) {
            item.classList.add('critical');
        }
    }
});