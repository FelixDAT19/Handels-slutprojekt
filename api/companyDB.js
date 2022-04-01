import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

export default async function handler(req, res) {
    if (req.method === "POST"){ 
        let plats = parseInt(req.body.plats); //puts specific id in to an in variable
        const company = await prisma.company.findUnique({where: {id: plats,}}); // query with specific comany id
        res.json([company]);
    }
}