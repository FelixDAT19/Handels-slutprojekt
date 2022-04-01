import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

export default async function handler(req, res) {
    const location = await prisma.placement.findMany({ orderBy: [{id: 'asc'}]}); // fetches location and company ids that belong to the placements from database.
    res.json(location); 
    
}