document.addEventListener('DOMContentLoaded', function() {
    const bookingDateInput = document.getElementById('booking_date');
    const bookingTimeInput = document.getElementById('booking_time');
    const numberInput = document.getElementById('number');

    const bookingDateValue = document.querySelector('.booking_value[data-type="date"]');
    const bookingTimeValue = document.querySelector('.booking_value[data-type="time"]');
    const numberValue = document.querySelector('.booking_value[data-type="number"]');

    function generateTimeOptions() {
        const now = new Date();
        const selectedDate = new Date(bookingDateInput.value);
        const isToday = selectedDate.toDateString() === now.toDateString();

        bookingTimeInput.innerHTML = '';

        for (let hour = 17; hour <= 21; hour++) {
            for (let minute = 0; minute < 60; minute += 30) {
                if (hour === 21 && minute === 30) {
                    continue;
                }
                const timeValue = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                
                if (isToday) {
                    const selectedTime = new Date(selectedDate.setHours(hour, minute));
                    if (selectedTime < now) {
                        continue;
                    }
                }

                const option = document.createElement('option');
                option.value = timeValue;
                option.textContent = timeValue;
                bookingTimeInput.appendChild(option);
            }
        }

        const lastOrderOption = document.createElement('option');
        lastOrderOption.value = '21:30';
        lastOrderOption.textContent = '21:30';
        bookingTimeInput.appendChild(lastOrderOption);
    }

    function updateBookingDetails() {
        bookingDateValue.textContent = bookingDateInput.value || '未設定';
        bookingTimeValue.textContent = bookingTimeInput.value || '未設定';
        numberValue.textContent = (numberInput.value ? numberInput.value + '人' : '未設定');
    }

    function validateBookingTime() {
        const now = new Date();
        const selectedDate = new Date(bookingDateInput.value);
        const inputTime = bookingTimeInput.value;

        if (!inputTime) return;

        const [hours, minutes] = inputTime.split(':').map(Number);
        const selectedTime = new Date(selectedDate.setHours(hours, minutes));

        if (selectedDate.toDateString() === now.toDateString()) {
            const minTime = new Date(now.getTime() + 1 * 60 * 60 * 1000);
            if (selectedTime < minTime) {
                alert('予約は現時刻から1時間以降に可能です');
                bookingTimeInput.value = '';
                return false;
            }
        }

        return true;
    }

    bookingDateInput.addEventListener('input', function() {
        generateTimeOptions();
        updateBookingDetails();
    });

    bookingTimeInput.addEventListener('input', function() {
        if (validateBookingTime()) {
            updateBookingDetails();
        }
    });

    numberInput.addEventListener('input', function() {
        const value = numberInput.value;
        if (value >= 1 && value <= 50) {
            numberInput.value = value;
            updateBookingDetails();
        } else {
            numberInput.value = '';
            updateBookingDetails();
        }
    });

    generateTimeOptions();
    updateBookingDetails();

    numberInput.placeholder = '1人';

    numberInput.addEventListener('focus', () => {
        numberInput.placeholder = '';
    });

    numberInput.addEventListener('blur', () => {
        if (numberInput.value === '') {
            numberInput.placeholder = '1人';
        } else {
            numberInput.placeholder = numberInput.value + '人';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const deleteButton = document.querySelector('form#delete-form button');

    if (deleteButton) {
        deleteButton.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('本当に削除しますか？')) {
                document.getElementById('delete-form').submit();
            }
        });
    }
});