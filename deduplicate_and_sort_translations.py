#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
脚本功能：对 resources/lang/zh_HK.json 文件进行去重和排序
- 去除重复的键（保留最后一个值）
- 按键名进行排序
- 保持 JSON 格式美观
"""

import json
from pathlib import Path
from collections import OrderedDict

def deduplicate_and_sort_json(file_path):
    """对 JSON 文件进行去重和排序"""
    file_path = Path(file_path)
    
    if not file_path.exists():
        print(f"错误：文件不存在 - {file_path}")
        return False
    
    try:
        # 读取 JSON 文件
        print(f"正在读取文件: {file_path}")
        with open(file_path, 'r', encoding='utf-8') as f:
            data = json.load(f)
        
        original_count = len(data)
        print(f"原始条目数: {original_count}")
        
        # 去重：使用 OrderedDict 保留最后一个值
        # 如果 JSON 解析时已经有重复键，json.load 会保留最后一个
        # 但为了确保，我们显式地创建一个新的字典
        deduplicated = {}
        duplicates = []
        
        # 检查并去重
        seen_keys = set()
        for key, value in data.items():
            if key in seen_keys:
                duplicates.append(key)
            else:
                seen_keys.add(key)
                deduplicated[key] = value
        
        if duplicates:
            print(f"发现重复键: {len(duplicates)} 个")
            for dup in duplicates[:10]:  # 只显示前10个
                print(f"  - {dup}")
            if len(duplicates) > 10:
                print(f"  ... 还有 {len(duplicates) - 10} 个")
        else:
            print("未发现重复键")
        
        # 排序：按键名排序
        print("\n正在按键名排序...")
        sorted_data = dict(sorted(deduplicated.items(), key=lambda x: x[0]))
        
        final_count = len(sorted_data)
        print(f"处理后条目数: {final_count}")
        
        # 写入文件
        print(f"\n正在保存到文件: {file_path}")
        with open(file_path, 'w', encoding='utf-8') as f:
            json.dump(sorted_data, f, ensure_ascii=False, indent=4)
        
        print("\n✓ 处理完成！")
        print(f"  - 原始条目: {original_count}")
        print(f"  - 处理后条目: {final_count}")
        if duplicates:
            print(f"  - 移除重复: {len(duplicates)} 个")
        
        return True
        
    except json.JSONDecodeError as e:
        print(f"错误：JSON 格式无效 - {e}")
        return False
    except Exception as e:
        print(f"错误：{e}")
        return False

if __name__ == '__main__':
    translation_file = 'resources/lang/zh_HK.json'
    print("=" * 60)
    print("翻译文件去重和排序工具")
    print("=" * 60)
    print()
    
    success = deduplicate_and_sort_json(translation_file)
    
    if success:
        print("\n文件已成功处理！")
    else:
        print("\n处理失败，请检查错误信息。")

