module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    darkMode: 'class',
    theme: {
        colors: {
            // إعادة تعريف الألوان الأساسية لتتوافق مع لوحة الألوان الخاصة بك
            transparent: 'transparent',
            current: 'currentColor',
            white: '#FFFFFF',
            black: '#2C2C2C', // يمكنك ضبطه حسب الحاجة

            // تخصيص درجات اللون الرمادي (Gray) المستخدمة في Flowbite
            gray: {
                50: '#FFFFFF',      // --bg-primary (أبيض نقي)
                100: '#F8F9FA',     // --bg-secondary
                200: '#F0F0F0',     // درجة متوسطة (اختياري)
                300: '#E8E8E8',     // --border-color
                400: '#DDDDDD',     // درجة أفتح قليلاً
                500: '#AAAAAA',     // يمكن استخدامه للـ placeholder
                600: '#888888',     // --text-light
                700: '#666666',     // --text-secondary
                800: '#444444',     // درجة أغمق قليلاً
                900: '#2C2C2C',     // --text-primary
            },

            // تخصيص درجات اللون الأزرق (Blue) ليصبح اللون الوردي هو الأساسي
            blue: {
                50: '#FFF0F3',      // وردي فاتح جداً
                100: '#FFE4E9',
                200: '#FFD9E0',
                300: '#FFC9D3',
                400: '#FFB6C1',     // --pC (اللون الرئيسي)
                500: '#FF9AA2',     // درجة أغمق (hover)
                600: '#F28B98',     // أغمق قليلاً
                700: '#E07A87',
                800: '#C66B77',
                900: '#A85A65',
            },

            // يمكنك أيضاً إضافة ألوان أخرى مثل red, green إذا احتجتها
        },
        extend: {
            // يمكن إضافة إعدادات إضافية هنا (مثل borderRadius, boxShadow)
            borderRadius: {
                base: '0.375rem', // 6px (يستخدم في Flowbite)
            },
            boxShadow: {
                xs: '0 1px 2px 0 rgba(0, 0, 0, 0.05)', // --shadow-color
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
    ],
};
