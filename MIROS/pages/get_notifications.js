async function getNewNotifications() {
    try {
        const response = await fetch('get_notifications.php?action=notifications');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('There was a problem with your fetch operation:', error);
        return null;
    }
}

async function alertForAnyNewNotifications(){
    try {
        const data = await getNewNotifications();
        const currentCount = data ? data.length : 0;
        const lastNotificationCount = sessionStorage.getItem('lastNotificationCount') || 0;

        if (currentCount > lastNotificationCount) {
            if (currentCount === 1) {
                const notification = data[0]; 
                alert(`New submission from ${notification.First_name} is awaiting verification.`);
            } else if (currentCount > 1) {
                alert(`You have ${currentCount} submissions awaiting verification.`);
            }
            sessionStorage.setItem('lastNotificationCount', currentCount);
        }
        return currentCount;
    } catch (error) {
        console.error('Error fetching notifications:', error);
        return 0;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    alertForAnyNewNotifications();
    const minute = 60000;
    setInterval(alertForAnyNewNotifications, 0.1 * minute);
});
