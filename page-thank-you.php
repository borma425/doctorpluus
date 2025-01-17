<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
</head>
<body style="margin: 0; padding: 0; height: 100vh; display: flex; justify-content: center; align-items: center; background: linear-gradient(135deg, #6a11cb, #2575fc); font-family: 'Arial', sans-serif; color: white;">

    <div style="text-align: center; background: rgba(255, 255, 255, 0.1); padding: 40px; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2); backdrop-filter: blur(10px);">
        <h1 style="font-size: 3rem; margin: 0; animation: fadeIn 2s ease-in-out;">تم تأكيد حجزك</h1>
        <p style="font-size: 1.2rem; margin: 10px 0 20px; animation: slideUp 1.5s ease-in-out;"> تم تأكيد حجزك بنجاح. يرجى ملاحظة أنه قد يتم الاتصال بك من أرقام غير معروفة، <br> لذا نرجو منك الرد في حال كانت الأرقام من جانبنا. </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" style="display: inline-block; background: #4a90e2; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-size: 1rem; font-weight: bold; transition: background 0.3s ease;">الرجوع للرئيسية</a>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        a:hover {
            background: #357abd; /* Darker shade on hover */
        }
    </style>

</body>
</html>