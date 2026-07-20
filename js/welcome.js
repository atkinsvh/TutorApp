/**
 * Tutor GoodVibez Life - Welcome JavaScript
 * Role-aware welcome messages for students, tutors, parents, and admins
 */

document.addEventListener('DOMContentLoaded', function() {
    const welcomeElement = document.getElementById('warmWelcome');
    
    if (welcomeElement) {
        const role = welcomeElement.getAttribute('data-user-role') || 'guest';
        const firstName = welcomeElement.getAttribute('data-user-name') || '';
        
        const welcomeMessage = generateWelcomeMessage(role, firstName);
        welcomeElement.innerHTML = welcomeMessage;
    }
});

/**
 * Generate role-aware welcome message
 * @param {string} role - User role (student, tutor, parent, admin)
 * @param {string} firstName - User's first name
 * @returns {string} HTML string for welcome message
 */
function generateWelcomeMessage(role, firstName) {
    const greetings = {
        student: {
            withName: `Welcome back, ${firstName}. Ready to learn, grow, and thrive today?`,
            withoutName: 'Welcome back! Ready to learn, grow, and thrive today?'
        },
        tutor: {
            withName: `Welcome back, ${firstName}. Ready to guide students and grow your tutoring business today?`,
            withoutName: 'Welcome back! Ready to guide students and grow your tutoring business today?'
        },
        parent: {
            withName: `Welcome back, ${firstName}. Here is your student\'s learning progress today.`,
            withoutName: 'Welcome back! Here is your student\'s learning progress today.'
        },
        admin: {
            withName: 'Welcome back, Admin. Here is your Tutor GoodVibez Life command center.',
            withoutName: 'Welcome back, Admin. Here is your Tutor GoodVibez Life command center.'
        },
        guest: {
            withName: `Welcome, ${firstName}! Explore our premium tutoring platform.`,
            withoutName: 'Welcome! Explore our premium tutoring platform.'
        }
    };
    
    const roleGreetings = greetings[role] || greetings.guest;
    const message = firstName ? roleGreetings.withName : roleGreetings.withoutName;
    
    return `
        <div class="welcome-message">
            <div class="welcome-icon">${getWelcomeIcon(role)}</div>
            <div class="welcome-text">
                <h2>${message}</h2>
                <p class="welcome-subtitle">${getWelcomeSubtitle(role)}</p>
            </div>
        </div>
    `;
}

/**
 * Get welcome icon based on role
 * @param {string} role - User role
 * @returns {string} Emoji icon
 */
function getWelcomeIcon(role) {
    const icons = {
        student: '📚',
        tutor: '🎓',
        parent: '👨‍👩‍👧',
        admin: '⚡',
        guest: '👋'
    };
    
    return icons[role] || icons.guest;
}

/**
 * Get welcome subtitle based on role
 * @param {string} role - User role
 * @returns {string} Subtitle text
 */
function getWelcomeSubtitle(role) {
    const subtitles = {
        student: 'Track your progress, complete assignments, and achieve your goals.',
        tutor: 'Manage your students, create assignments, and grow your business.',
        parent: 'Monitor your student\'s academic progress and stay connected.',
        admin: 'Manage users, tutor applications, and platform settings.',
        guest: 'Sign up today to start your learning journey.'
    };
    
    return subtitles[role] || subtitles.guest;
}

/**
 * Update welcome message dynamically
 * @param {string} role - New user role
 * @param {string} firstName - New user name
 */
function updateWelcomeMessage(role, firstName) {
    const welcomeElement = document.getElementById('warmWelcome');
    
    if (welcomeElement) {
        welcomeElement.setAttribute('data-user-role', role);
        welcomeElement.setAttribute('data-user-name', firstName);
        
        const welcomeMessage = generateWelcomeMessage(role, firstName);
        welcomeElement.innerHTML = welcomeMessage;
    }
}
