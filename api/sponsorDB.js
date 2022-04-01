import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

export default async function handler(req, res) {
    const sponsors = await prisma.sponsors.findMany();
    res.json(sponsors); // fetches sponsors from database.
    console.log(sponsors)
}