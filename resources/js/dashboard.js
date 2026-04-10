import Chart from 'chart.js/auto';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import '@fullcalendar/core/index.global.css';

document.addEventListener('DOMContentLoaded', function() {
    // Convert PHP → JS safely
    const rawAchievements = window.achievementsMonthly || [];
    
    // Build array of 12 months, fill missing with 0
    const monthlyAchievements = Array.from({ length: 12 }, (_, i) => rawAchievements[i + 1] ?? 0);
    
    // Expense data
    const expensesData = Object.values(window.athleteCategories || {});
    const expensesLabels = Object.keys(window.athleteCategories || {});
    
    // If empty, avoid chart errors
    const finalLabels = expensesLabels.length > 0 ? expensesLabels : ["No Data"];
    const finalData = expensesData.length > 0 ? expensesData : [1];
    
    const monthlyLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    
    /* BAR CHART – Monthly Achievements */
    const achievementChartEl = document.getElementById('achievementChart');
    if (achievementChartEl) {
        new Chart(achievementChartEl, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Achievements',
                    data: monthlyAchievements,
                    backgroundColor: 'rgba(99,102,241,0.6)',
                    borderColor: 'rgba(99,102,241,1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }
    
    /* FullCalendar – Schedule */
    const scheduleEvents = window.scheduleEvents || [];
    const scheduleCalendarEl = document.getElementById('scheduleCalendar');
    
    if (scheduleCalendarEl) {
        const calendar = new Calendar(scheduleCalendarEl, {
            plugins: [dayGridPlugin],
            initialView: 'dayGridMonth',
            height: 'auto',
            events: scheduleEvents,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            eventColor: '#6366f1',
            eventTextColor: '#fff'
        });
        
        calendar.render();
    }
});
