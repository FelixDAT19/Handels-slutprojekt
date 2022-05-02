import { PrismaClient } from "@prisma/client"; //importerat prisma clienten

let prisma = new PrismaClient() //generates the prisma client for the database connection

export default prisma;