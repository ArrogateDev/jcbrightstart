<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>验证您的账户</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f6f9fc;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .email-header {
            background-color: #4a6ee0;
            color: white;
            padding: 24px 30px;
            text-align: center;
        }

        .email-logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .email-title {
            font-size: 20px;
            margin: 0;
        }

        .email-body {
            padding: 30px;
        }

        .greeting {
            margin-bottom: 20px;
        }

        .instructions {
            margin-bottom: 25px;
            color: #555555;
        }

        .verification-code {
            display: block;
            width: 280px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border: 2px dashed #4a6ee0;
            border-radius: 8px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #4a6ee0;
        }

        .action-button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 12px 20px;
            background-color: #4a6ee0;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 16px;
        }

        .action-button:hover {
            background-color: #3a5bc7;
        }

        .expiry-notice {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 25px 0;
            font-size: 14px;
            color: #666666;
            border-left: 4px solid #4a6ee0;
        }

        .usage-instructions {
            margin-top: 30px;
            padding: 20px;
            background-color: #f0f7ff;
            border-radius: 6px;
        }

        .usage-instructions h3 {
            color: #4a6ee0;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .usage-instructions ol {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .usage-instructions li {
            margin-bottom: 10px;
        }

        .security-tips {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
        }

        .security-tips h3 {
            color: #4a6ee0;
            margin-bottom: 15px;
        }

        .security-tips ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .security-tips li {
            margin-bottom: 8px;
        }

        .contact-info {
            margin-top: 25px;
            font-size: 14px;
            color: #777777;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #888888;
        }

        .email-footer a {
            color: #4a6ee0;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
            }

            .email-body {
                padding: 20px;
            }

            .verification-code {
                width: 90%;
                font-size: 28px;
                letter-spacing: 6px;
                padding: 15px;
            }

            .action-button {
                width: 90%;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <div class="email-logo">{{env('MAIL_FROM_NAME')}}</div>
        <h1 class="email-title">账户验证</h1>
    </div>

    <div class="email-body">
        <p class="greeting">尊敬的{{$first_name}}，</p>

        <p class="instructions">您正在进行账户安全验证，请使用以下验证码完成操作：</p>

        <div class="verification-code">{{$code}}</div>

        <div class="usage-instructions">
            <h3>如何使用验证码</h3>
            <ol>
                <li>返回您的账户验证页面</li>
                <li>在验证码输入框中输入上方6位数字</li>
                <li>点击"验证"按钮完成验证</li>
            </ol>
        </div>

        <div class="expiry-notice">
            <strong>重要提示：</strong> 此验证码将在10分钟后失效。如果您没有请求此验证码，请忽略此邮件。
        </div>

        <div class="security-tips">
            <h3>安全提醒</h3>
            <ul>
                <li>请勿将验证码透露给任何人，包括我们的客服人员</li>
                <li>我们绝不会通过电话或短信向您索要验证码</li>
                <li>如果您收到非本人操作的验证请求，请立即更改密码</li>
                <li>定期检查账户活动，确保没有异常登录</li>
            </ul>
        </div>

        <div class="contact-info">
            <p>如果您遇到任何问题或需要帮助，请联系我们的客服团队：</p>
            <p>邮箱：{{env('MAIL_FROM_ADDRESS')}}</p>
        </div>
    </div>

    <div class="email-footer">
        <p>此邮件由系统自动发送，请勿直接回复。</p>
        <p>© {{date('Y')}} {{env('APP_NAME')}}. 保留所有权利。</p>
        <p><a href="#">隐私政策</a> | <a href="#">使用条款</a></p>
    </div>
</div>
</body>
</html>
