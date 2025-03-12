/**
 * DatePicker Component JavaScript
 *
 * Handles date selection, calendar navigation, and user interactions
 */
(function () {
    'use strict';

    // Localization data for different languages
    const localeData = {
        'en': {
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            weekdaysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            weekdaysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            today: 'Today',
            clear: 'Clear',
            close: 'Close'
        },
        'fr': {
            months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthsShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            weekdaysMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
            today: 'Aujourd\'hui',
            clear: 'Effacer',
            close: 'Fermer'
        },
        'es': {
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            weekdaysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            today: 'Hoy',
            clear: 'Borrar',
            close: 'Cerrar'
        },
        'de': {
            months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
            monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            weekdays: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
            weekdaysShort: ['Son', 'Mon', 'Die', 'Mit', 'Don', 'Fre', 'Sam'],
            weekdaysMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
            today: 'Heute',
            clear: 'Löschen',
            close: 'Schließen'
        }
    };

    // When DOM is ready
    document.addEventListener('DOMContentLoaded', function () {
        // Find all datepicker wrappers
        const datepickerWrappers = document.querySelectorAll('.datepicker-wrapper');

        // Initialize each datepicker
        datepickerWrappers.forEach(function (wrapper) {
            initDatepicker(wrapper);
        });

        // Document click to close open datepickers
        document.addEventListener('click', function (e) {
            // Close any open calendars when clicking outside
            const openCalendars = document.querySelectorAll('.datepicker-calendar[style*="display: block"]');
            openCalendars.forEach(function (calendar) {
                const wrapper = calendar.closest('.datepicker-wrapper');
                if (wrapper && !wrapper.contains(e.target)) {
                    calendar.style.display = 'none';
                }
            });
        });
    });

    /**
     * Initialize a single datepicker
     */
    function initDatepicker(wrapper) {
        const input = wrapper.querySelector('input[data-datepicker="true"]');
        const calendar = wrapper.querySelector('.datepicker-calendar');
        const icon = wrapper.querySelector('.datepicker-icon');

        if (!input || !calendar) return;

        // Hide calendar initially
        calendar.style.display = 'none';

        // Get locale from calendar
        const localeCode = calendar.dataset.locale || 'en';
        const locale = localeData[localeCode] || localeData['en'];

        // Show calendar when clicking icon
        if (icon) {
            icon.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                toggleCalendar(calendar, input, locale);
            });
        }

        // Show calendar on input focus
        if (!input.readOnly && !input.disabled) {
            input.addEventListener('focus', function (e) {
                e.stopPropagation();
                showCalendar(calendar, input, locale);
            });
        }

        // Stop propagation on calendar clicks
        calendar.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Handle input changes
        input.addEventListener('change', function () {
            const date = parseInputDate(input.value, input.dataset.format || 'Y-m-d');
            if (date) {
                // Nothing needed here, the calendar will show the right month
                // when opened next time
            }
        });

        // Set up date range functionality if needed
        if (input.hasAttribute('data-range-start') || input.hasAttribute('data-range-end')) {
            setupDateRange(input);
        }
    }

    /**
     * Toggle calendar visibility
     */
    function toggleCalendar(calendar, input, locale) {
        if (calendar.style.display === 'none') {
            showCalendar(calendar, input, locale);
        } else {
            calendar.style.display = 'none';
        }
    }

    /**
     * Show calendar with current or selected date
     */
    function showCalendar(calendar, input, locale) {
        // Force English locale if none specified or not found
        if (!locale) {
            const localeCode = calendar.dataset.locale || 'en';
            locale = localeData[localeCode] || localeData['en'];
        }

        // Determine date to show
        let currentDate = new Date();
        const selectedValue = input.value;

        if (selectedValue) {
            const parsedDate = parseInputDate(selectedValue, input.dataset.format || 'Y-m-d');
            if (parsedDate) {
                currentDate = parsedDate;
            }
        }

        // Render calendar with this date
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Store current view in data attributes
        calendar.dataset.viewYear = year;
        calendar.dataset.viewMonth = month;

        // Render the calendar
        renderCalendar(calendar, input, locale);

        // Position and show
        positionCalendar(calendar, input);
        calendar.style.display = 'block';
    }

    /**
     * Render the calendar for the specified month/year
     */
    function renderCalendar(calendar, input, locale) {
        // Get current view from data attributes
        const viewYear = parseInt(calendar.dataset.viewYear);
        const viewMonth = parseInt(calendar.dataset.viewMonth);

        // Create calendar components
        const header = createHeader(viewYear, viewMonth, locale);
        const body = createBody(viewYear, viewMonth, input, locale);
        const footer = createFooter(calendar, input, locale);

        // Clear calendar
        calendar.innerHTML = '';

        // Append components
        calendar.appendChild(header);
        calendar.appendChild(body);
        calendar.appendChild(footer);

        // Add direct navigation event handlers
        const prevBtn = header.querySelector('.datepicker-prev-btn');
        const nextBtn = header.querySelector('.datepicker-next-btn');

        prevBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            moveMonth(calendar, input, -1);
            return false;
        });

        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            moveMonth(calendar, input, 1);
            return false;
        });
    }

    /**
     * Move to previous/next month
     */
    function moveMonth(calendar, input, direction) {
        // Get the locale
        const localeCode = calendar.dataset.locale || 'en';
        const locale = localeData[localeCode] || localeData['en'];

        // Get current view from data attributes
        let viewYear = parseInt(calendar.dataset.viewYear);
        let viewMonth = parseInt(calendar.dataset.viewMonth);

        // Calculate new month/year
        viewMonth += direction;

        if (viewMonth < 0) {
            viewMonth = 11;
            viewYear--;
        } else if (viewMonth > 11) {
            viewMonth = 0;
            viewYear++;
        }

        // Update data attributes
        calendar.dataset.viewYear = viewYear;
        calendar.dataset.viewMonth = viewMonth;

        // Re-render the calendar
        renderCalendar(calendar, input, locale);
    }

    /**
     * Create the calendar header with month/year display and navigation
     */
    function createHeader(year, month, locale) {
        const header = document.createElement('div');
        header.className = 'datepicker-header';

        // Previous month button
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = 'datepicker-prev-btn';
        prevBtn.innerHTML = '&laquo;';
        prevBtn.setAttribute('aria-label', 'Previous month');

        // Month/year title
        const title = document.createElement('div');
        title.className = 'datepicker-title';
        title.textContent = locale.months[month] + ' ' + year;

        // Next month button
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = 'datepicker-next-btn';
        nextBtn.innerHTML = '&raquo;';
        nextBtn.setAttribute('aria-label', 'Next month');

        // Append elements
        header.appendChild(prevBtn);
        header.appendChild(title);
        header.appendChild(nextBtn);

        return header;
    }

    /**
     * Create the calendar body with weekdays and days grid
     */
    function createBody(year, month, input, locale) {
        const body = document.createElement('div');
        body.className = 'datepicker-body';

        // Create weekday headers
        const weekdays = document.createElement('div');
        weekdays.className = 'datepicker-weekdays';

        // Get first day of week
        const firstDay = 0; // Default to Sunday

        // Add weekday labels
        for (let i = 0; i < 7; i++) {
            const weekdayIndex = (i + firstDay) % 7;
            const dayLabel = document.createElement('div');
            dayLabel.className = 'datepicker-weekday';
            dayLabel.textContent = locale.weekdaysMin[weekdayIndex];
            weekdays.appendChild(dayLabel);
        }

        body.appendChild(weekdays);

        // Create days grid
        const daysGrid = document.createElement('div');
        daysGrid.className = 'datepicker-days';

        // Calculate dates
        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        // Adjust for first day of week
        const startOffset = (firstDayOfMonth - firstDay + 7) % 7;

        // Today's date for highlighting
        const today = new Date();
        const isCurrentMonth = today.getMonth() === month && today.getFullYear() === year;
        const todayDate = isCurrentMonth ? today.getDate() : -1;

        // Selected date
        const selectedDate = input.value ? parseInputDate(input.value, input.dataset.format || 'Y-m-d') : null;
        const isSelectedMonth = selectedDate && selectedDate.getMonth() === month && selectedDate.getFullYear() === year;
        const selectedDay = isSelectedMonth ? selectedDate.getDate() : -1;

        // Min/max dates
        const minDate = input.dataset.minDate ? parseInputDate(input.dataset.minDate, 'Y-m-d') : null;
        const maxDate = input.dataset.maxDate ? parseInputDate(input.dataset.maxDate, 'Y-m-d') : null;

        // Create all days for the grid (6 rows x 7 days = 42 cells)
        let nextMonthDay = 1;

        for (let i = 0; i < 42; i++) {
            const dayCell = document.createElement('div');
            dayCell.className = 'datepicker-day';

            // Previous month days
            if (i < startOffset) {
                const prevDay = daysInPrevMonth - startOffset + i + 1;
                dayCell.textContent = prevDay;
                dayCell.classList.add('datepicker-day-other-month');

                // Calculate actual date
                const prevMonth = month === 0 ? 11 : month - 1;
                const prevYear = month === 0 ? year - 1 : year;
                const date = new Date(prevYear, prevMonth, prevDay);

                dayCell.dataset.date = formatDate(date, 'Y-m-d');

                if (isDateSelectable(date, minDate, maxDate)) {
                    dayCell.classList.add('datepicker-day-selectable');
                    addDayClickHandler(dayCell, input);
                } else {
                    dayCell.classList.add('datepicker-day-disabled');
                }
            }
            // Current month days
            else if (i < startOffset + daysInMonth) {
                const day = i - startOffset + 1;
                dayCell.textContent = day;

                // Calculate actual date
                const date = new Date(year, month, day);
                dayCell.dataset.date = formatDate(date, 'Y-m-d');

                // Highlight today
                if (day === todayDate) {
                    dayCell.classList.add('datepicker-day-today');
                }

                // Highlight selected day
                if (day === selectedDay) {
                    dayCell.classList.add('datepicker-day-selected');
                }

                if (isDateSelectable(date, minDate, maxDate)) {
                    dayCell.classList.add('datepicker-day-selectable');
                    addDayClickHandler(dayCell, input);
                } else {
                    dayCell.classList.add('datepicker-day-disabled');
                }
            }
            // Next month days
            else {
                dayCell.textContent = nextMonthDay;
                dayCell.classList.add('datepicker-day-other-month');

                // Calculate actual date
                const nextMonth = month === 11 ? 0 : month + 1;
                const nextYear = month === 11 ? year + 1 : year;
                const date = new Date(nextYear, nextMonth, nextMonthDay);

                dayCell.dataset.date = formatDate(date, 'Y-m-d');

                if (isDateSelectable(date, minDate, maxDate)) {
                    dayCell.classList.add('datepicker-day-selectable');
                    addDayClickHandler(dayCell, input);
                } else {
                    dayCell.classList.add('datepicker-day-disabled');
                }

                nextMonthDay++;
            }

            daysGrid.appendChild(dayCell);
        }

        body.appendChild(daysGrid);
        return body;
    }

    /**
     * Create the calendar footer with Today/Clear buttons
     */
    function createFooter(calendar, input, locale) {
        const footer = document.createElement('div');
        footer.className = 'datepicker-footer';

        // Show Today button if enabled
        const showToday = calendar.dataset.showToday !== 'false';
        if (showToday) {
            const todayBtn = document.createElement('button');
            todayBtn.type = 'button';
            todayBtn.className = 'datepicker-today-btn';
            todayBtn.textContent = locale.today;

            todayBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Select today's date
                const today = new Date();
                selectDate(today, input);

                // Hide calendar
                calendar.style.display = 'none';
            });

            footer.appendChild(todayBtn);
        }

        // Show Clear button if enabled
        const showClear = calendar.dataset.showClear !== 'false';
        if (showClear) {
            const clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.className = 'datepicker-clear-btn';
            clearBtn.textContent = locale.clear;

            clearBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Clear input value
                input.value = '';

                // Trigger change event
                const event = new Event('change');
                input.dispatchEvent(event);

                // Hide calendar
                calendar.style.display = 'none';
            });

            footer.appendChild(clearBtn);
        }

        return footer;
    }

    /**
     * Add click handler to day cell
     */
    function addDayClickHandler(dayCell, input) {
        dayCell.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Get date from data attribute
            const dateStr = dayCell.dataset.date;
            const date = parseInputDate(dateStr, 'Y-m-d');

            if (date) {
                selectDate(date, input);

                // Hide calendar
                const calendar = this.closest('.datepicker-calendar');
                if (calendar) {
                    calendar.style.display = 'none';
                }
            }
        });
    }

    /**
     * Select a date and update input
     */
    function selectDate(date, input) {
        // Format date according to input's format
        const format = input.dataset.format || 'Y-m-d';
        const formattedDate = formatDate(date, format);

        // Update input value
        input.value = formattedDate;

        // Trigger change event
        const event = new Event('change');
        input.dispatchEvent(event);
    }

    /**
     * Position calendar below input
     */
    function positionCalendar(calendar, input) {
        const inputRect = input.getBoundingClientRect();
        const wrapperRect = input.closest('.datepicker-wrapper').getBoundingClientRect();

        // Calculate top position (below input)
        const top = inputRect.bottom - wrapperRect.top;

        // Set position
        calendar.style.top = top + 'px';
        calendar.style.left = '0';

        // Check if calendar would go off-screen
        const calendarRect = calendar.getBoundingClientRect();
        if (calendarRect.right > window.innerWidth) {
            const rightOffset = calendarRect.right - window.innerWidth + 10;
            calendar.style.left = `-${rightOffset}px`;
        }
    }

    /**
     * Set up date range functionality
     */
    function setupDateRange(input) {
        if (input.hasAttribute('data-range-start')) {
            const endInput = document.querySelector('input[data-range-end]');
            if (endInput) {
                input.addEventListener('change', function () {
                    const startDate = input.value;
                    if (startDate) {
                        endInput.dataset.minDate = startDate;

                        // Update end date if it's before start date
                        if (endInput.value && endInput.value < startDate) {
                            endInput.value = startDate;

                            // Trigger change event
                            const event = new Event('change');
                            endInput.dispatchEvent(event);
                        }
                    }
                });
            }
        } else if (input.hasAttribute('data-range-end')) {
            const startInput = document.querySelector('input[data-range-start]');
            if (startInput) {
                input.addEventListener('change', function () {
                    const endDate = input.value;
                    if (endDate) {
                        startInput.dataset.maxDate = endDate;

                        // Update start date if it's after end date
                        if (startInput.value && startInput.value > endDate) {
                            startInput.value = endDate;

                            // Trigger change event
                            const event = new Event('change');
                            startInput.dispatchEvent(event);
                        }
                    }
                });
            }
        }
    }

    /**
     * Check if a date is selectable (within min/max range)
     */
    function isDateSelectable(date, minDate, maxDate) {
        const timestamp = date.getTime();

        if (minDate && timestamp < minDate.getTime()) {
            return false;
        }

        if (maxDate && timestamp > maxDate.getTime()) {
            return false;
        }

        return true;
    }

    /**
     * Parse date from string
     */
    function parseInputDate(dateStr, format) {
        if (!dateStr) return null;

        // Handle common formats
        if (format === 'Y-m-d') {
            // YYYY-MM-DD
            const parts = dateStr.split('-');
            if (parts.length === 3) {
                const year = parseInt(parts[0]);
                const month = parseInt(parts[1]) - 1; // JS months are 0-based
                const day = parseInt(parts[2]);

                return new Date(year, month, day);
            }
        } else if (format === 'm/d/Y') {
            // MM/DD/YYYY
            const parts = dateStr.split('/');
            if (parts.length === 3) {
                const year = parseInt(parts[2]);
                const month = parseInt(parts[0]) - 1;
                const day = parseInt(parts[1]);

                return new Date(year, month, day);
            }
        } else if (format === 'd.m.Y') {
            // DD.MM.YYYY
            const parts = dateStr.split('.');
            if (parts.length === 3) {
                const year = parseInt(parts[2]);
                const month = parseInt(parts[1]) - 1;
                const day = parseInt(parts[0]);

                return new Date(year, month, day);
            }
        }

        // Fallback to browser's date parsing
        return new Date(dateStr);
    }

    /**
     * Format date to string according to format
     */
    function formatDate(date, format) {
        const year = date.getFullYear();
        const month = date.getMonth() + 1; // JS months are 0-based
        const day = date.getDate();

        // Use English locale data for formatting - locale is only used for display in calendar
        const locale = localeData['en'];

        // Replace format tokens
        return format
            .replace('Y', year)
            .replace('m', month < 10 ? '0' + month : month)
            .replace('n', month)
            .replace('d', day < 10 ? '0' + day : day)
            .replace('j', day)
            .replace('F', locale.months[date.getMonth()])
            .replace('M', locale.monthsShort[date.getMonth()]);
    }

})();