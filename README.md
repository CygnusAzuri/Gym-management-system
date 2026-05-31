# Gym Management System

A web-based gym management application with role-based access 
for admins, members, and trainers.

🔗 [Live Demo](https://github.com/CygnusAzuri/Gym-management-system)

---

## Features

- **Role-based login** — separate access for Admin, Member, and User
- **Member management** — track member profiles, descriptions, and credentials
- **Trainer management** — manage trainer details and assignments
- **Payment tracking** — log payment amounts, dates, and descriptions
- **Gym catalogue** — manage gym types and descriptions

---

## Database Design

Designed a relational schema with 6 entities:

| Entity | Key Attributes |
|---|---|
| Admin | admin_id, admin_password |
| Member | mem_id, mem_password, mem_desc |
| User | user_id, user_name, user_mob, user_gen |
| Trainer | train_id, train_name, train_mob |
| Payment | pay_id, pay_amt, pay_date, pay_desc |
| Gym | gym_type, gym_desc |

---

## Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML, CSS, JavaScript |
| Database Design | Relational schema (ERD) |

---

## How to Run Locally

```bash
git clone https://github.com/CygnusAzuri/Gym-management-system
cd Gym-management-system
# Open index.html in browser
```

---

## Built By

[Sakshi Jha](https://linkedin.com/in/sakshijha2003) — CS Undergrad @ IGDTUW
