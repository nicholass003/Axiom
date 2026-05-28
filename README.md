# ⚡ Axiom

A protocol translation library for Minecraft Bedrock Edition.

Lightweight, extensible, and designed for multi-version support.

---

## ✨ Features

* Multi-version Bedrock protocol support
* Clean codec-based architecture
* Lightweight and extensible design
* Strict typing with modern PHP
* Protocol inheritance system
* Virion-compatible for PocketMine-MP

---

## 📋 Supported Protocols

| Protocol | Minecraft Version |
| -------- | ----------------- |
| 1001     | 1.26.30           |
| 975      | 1.26.20           |
| 944      | 1.26.10           |
| 924      | 1.26.0            |
| 898      | 1.21.130          |
| 860      | 1.21.124          |
| 859      | 1.21.120          |
| 844      | 1.21.111          |

---

## 📦 Installation

```bash
composer require nicholass003/axiom
```

---

## 🚀 Basic Usage

```php
use Nicholass003\Axiom\Axiom;

$builder = Axiom::for(898);
```

```php
$codec = $builder->get($packetId);
$packet = $codec->decode($reader, $builder->getCodecType());
```

---
