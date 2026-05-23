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
| 844      | 1.21.111          |
| 859      | 1.21.120          |
| 860      | 1.21.124          |
| 898      | 1.21.130          |
| 924      | 1.26.0            |
| 944      | 1.26.10           |
| 975      | 1.26.20           |

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
