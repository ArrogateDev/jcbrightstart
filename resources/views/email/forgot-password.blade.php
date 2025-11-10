<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>密码重置 - 您的账户</title>
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

        .reset-button {
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

        .reset-button:hover {
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

        /* 响应式设计 */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
            }

            .email-body {
                padding: 20px;
            }

            .reset-button {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="email-logo">{{env('MAIL_FROM_NAME')}}</div>
            <h1 class="email-title">密码重置请求</h1>
        </div>

        <div class="email-body">
            <p class="greeting">尊敬的{{$full_name}}，</p>

            <p class="instructions">我们收到了您重置账户密码的请求。请点击下方按钮来设置新密码：</p>

            <a href="{{$url}}" class="reset-button">重置密码</a>

            <div class="expiry-notice">
                <strong>重要提示：</strong> 此链接将在24小时后失效。如果您没有请求重置密码，请忽略此邮件。
            </div>

            <p>如果上方按钮无法点击，请复制以下链接到浏览器地址栏：</p>
            <p style="word-break: break-all; color: #4a6ee0; font-size: 14px;">{{$url}}</p>

            <div class="security-tips">
                <h3>账户安全提示</h3>
                <ul>
                    <li>请勿将密码透露给任何人</li>
                    <li>定期更换密码以确保账户安全</li>
                    <li>避免在不同网站使用相同密码</li>
                    <li>启用双重验证以增强账户保护</li>
                </ul>
            </div>

            <div class="contact-info">
                <p>如果您需要帮助，请联系我们的客服团队：</p>
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
